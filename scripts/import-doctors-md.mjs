import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, "..");

function normDoctorName(str) {
    return String(str)
        .replace(/^Dr\.?\s*/i, "dr ")
        .replace(/\s+/g, " ")
        .trim()
        .toLowerCase();
}

function isProbableDoctorNameLine(clean) {
    if (/^\(Prof\)\s*Dr\.?|^Prof\.?\s*Dr\.?/i.test(clean)) return true;
    if (!/^Dr\.?\s+/i.test(clean)) return false;
    if (clean.length > 95) return false;
    const wc = clean.split(/\s+/).length;
    if (wc > 12) return false;
    if (/\b(has|had|is|was|completed|experience|career|member|actively|extensive)\b/i.test(clean)) return false;
    if (/,\s*(Senior|Consultant|Department|MD|MBBS|MS|DM|DNB|PDF|Fellow)/i.test(clean)) return false;
    return true;
}

function parseDoctors(rawText) {
    const text = String(rawText).replace(/^\uFEFF/, "");
    const allLines = text.split(/\r?\n/).map((x) => x.trim()).filter(Boolean);
    let start = 0;
    for (let i = 0; i < allLines.length; i++) {
        if (/^#####\s+/.test(allLines[i])) {
            start = i;
            break;
        }
    }
    const lines = allLines.slice(start);
    const departments = [];
    let dept = null;
    let doc = null;

    function pushDoc() {
        if (dept && doc && doc.name) dept.doctors.push(doc);
        doc = null;
    }
    function pushDept() {
        pushDoc();
        if (dept && dept.title) departments.push(dept);
    }

    for (const line of lines) {
        if (/^######/.test(line)) continue;
        if (/^####\s+Dr/i.test(line)) continue;
        if (/^####\s+\[Dr\./i.test(line)) continue;

        const clean = line.replace(/^#+\s*/, "").trim();
        if (
            /^Source URL:/i.test(clean) ||
            /^Title:/i.test(clean) ||
            /^URL Source:/i.test(clean) ||
            /^Markdown Content:/i.test(clean) ||
            clean === "×" ||
            /^GET AN APPOINTMENT!?$/i.test(clean)
        ) {
            continue;
        }

        if (/^#####\s+/.test(line)) {
            const candidate = clean.replace(/\s+/g, " ").trim();
            if (candidate && !/^Dr\.?/i.test(candidate) && !/^Availability/i.test(candidate)) {
                pushDept();
                dept = { title: candidate, doctors: [] };
                continue;
            }
        }

        if (isProbableDoctorNameLine(clean)) {
            if (doc && normDoctorName(doc.name) === normDoctorName(clean)) {
                continue;
            }
            pushDoc();
            if (!dept) dept = { title: "Doctors", doctors: [] };
            doc = { name: clean, meta: [], body: [] };
            continue;
        }

        if (!dept) dept = { title: "Doctors", doctors: [] };
        if (!doc) doc = { name: "Doctor Profile", meta: [], body: [] };

        if (
            /^Availability/i.test(clean) ||
            /^Consultant/i.test(clean) ||
            /^Senior Consultant/i.test(clean) ||
            /^Sr\.?\s*Consultant/i.test(clean) ||
            /^HOD/i.test(clean) ||
            /^Head\b/i.test(clean) ||
            /^Department\b/i.test(clean) ||
            /^MBBS/i.test(clean) ||
            /^Qualifications?/i.test(clean) ||
            /^MD\b/i.test(clean) ||
            /^DM\b/i.test(clean) ||
            /^DNB/i.test(clean) ||
            /^MS\b/i.test(clean) ||
            /^MCh/i.test(clean) ||
            /^PDF\b/i.test(clean) ||
            /^FRCS/i.test(clean) ||
            /^MRCP/i.test(clean) ||
            /^Fellow/i.test(clean)
        ) {
            doc.meta.push(clean);
        } else if (!/^GET AN APPOINTMENT!?$/i.test(clean)) {
            doc.body.push(clean);
        }
    }
    pushDept();
    return departments.filter((d) => d.doctors.length > 0);
}

/** Strip Jina reader preamble; turn linked doctor headings into plain name lines */
function normalizeRawMd(raw) {
    let s = String(raw).replace(/^\uFEFF/, "");
    s = s.replace(/^[\s\S]*?Markdown Content:\s*/i, "");

    function asDoctorLine(namePart) {
        let n = String(namePart).trim();
        if (/^\(Prof\.\)\s*Dr\.?/i.test(n)) return n.replace(/\s+/g, " ");
        if (/^Dr\.?\s/i.test(n)) return n.replace(/^Dr\.?\s*/i, "Dr. ").replace(/\s+/g, " ");
        return "Dr. " + n.replace(/\s+/g, " ");
    }

    s = s.replace(/^####\s+\[\(Prof\.\)\s*Dr\.?\s*([^\]]+)\]\([^)]*\)/gim, (_, inner) => asDoctorLine("(Prof.) Dr. " + inner.trim()));
    s = s.replace(/^####\s+\[Dr\.?\s*([^\]]+)\]\([^)]*\)/gim, (_, inner) => asDoctorLine(inner));
    return s;
}

const jinaPath = process.argv[2];
const outPath = path.join(root, "assets", "data", "doctors-page.md");

if (!jinaPath) {
    console.error("Usage: node import-doctors-md.mjs <path-to-jina-or-md-export.txt>");
    process.exit(1);
}

const raw = fs.readFileSync(jinaPath, "utf8");
const normalized = normalizeRawMd(raw);
const depts = parseDoctors(normalized);
const totalDocs = depts.reduce((n, d) => n + d.doctors.length, 0);

const header = `Source URL: https://sumum.soahospitals.com/doctors-page/
Title: Ultimate Doctors - Sum Ultimate | Best Hospitals In Bhubaneswar |

`;

const body = normalized.trim() + "\n";
fs.writeFileSync(outPath, header + "\n" + body, "utf8");
console.log("Wrote", outPath);
console.log("Departments:", depts.length, "Doctors:", totalDocs);
