(function () {

  var grid = document.getElementById('sumDoctorGrid');

  if (!grid || !window.sumDoctorsById) return;



  var modal = document.getElementById('sumDoctorModal');

  var backdrop = document.getElementById('sumDoctorModalBackdrop');

  var panel = document.getElementById('sumDoctorModalPanel');

  var closeBtn = document.getElementById('sumDoctorModalClose');

  var listReturnUrl = window.location.pathname + window.location.search;



  function profileUrl(id) {

    var doc = window.sumDoctorsById[id];

    if (doc && doc.profileUrl) return doc.profileUrl;

    return 'doctors/' + encodeURIComponent(id);

  }



  function doctorIdFromLocation() {

    var path = window.location.pathname || '';

    var match = path.match(/\/doctors\/([a-zA-Z0-9\-]+)\/?$/i);

    if (match) return match[1];

    var params = new URLSearchParams(window.location.search);

    return params.get('doctor') || params.get('id') || null;

  }



  function isDoctorProfilePath(path) {

    return /\/doctors\/[a-zA-Z0-9\-]+\/?$/i.test(path || '');

  }



  function renderProfile(id) {

    var doc = window.sumDoctorsById[id];

    if (!doc || !panel) return false;

    var deptSlug = doc.departmentSlug || '';

    var deptUrl = 'department-detail.php?dept=' + encodeURIComponent(deptSlug);

    var bio = doc.bio || '';

    panel.innerHTML =
      '<article class="sum-doctor-profile sum-doctor-profile--modal">' +
        '<header class="sum-doctor-profile__hero">' +
          '<div class="sum-doctor-profile__hero-bg" aria-hidden="true"></div>' +
          '<div class="sum-doctor-profile__hero-grid">' +
            '<div class="sum-doctor-profile__photo-wrap">' +
              '<div class="sum-doctor-profile__photo"><img src="' + escapeHtml(doc.image) + '" alt="' + escapeHtml(doc.name) + '"></div>' +
            '</div>' +
            '<div class="sum-doctor-profile__intro">' +
              '<p class="sum-doctor-profile__eyebrow">Consultant Profile</p>' +
              '<a href="' + escapeHtml(deptUrl) + '" class="sum-doctor-profile__badge">' + escapeHtml(doc.department) + '</a>' +
              '<h2 id="sumDoctorModalTitle" class="sum-doctor-profile__name">' + escapeHtml(doc.name) + '</h2>' +
              (doc.qualification ? '<p class="sum-doctor-profile__qual"><i class="fas fa-graduation-cap" aria-hidden="true"></i> ' + escapeHtml(doc.qualification) + '</p>' : '') +
              '<div class="sum-doctor-profile__actions">' +
                '<a href="https://appt.soahospitals.com/" class="sum-doctor-profile__btn sum-doctor-profile__btn--primary" target="_blank" rel="noopener"><i class="fas fa-calendar-check" aria-hidden="true"></i> Book Appointment</a>' +
                '<a href="tel:+916743500500" class="sum-doctor-profile__btn sum-doctor-profile__btn--outline"><i class="fas fa-phone-alt" aria-hidden="true"></i> Call Hospital</a>' +
              '</div>' +
            '</div>' +
          '</div>' +
        '</header>' +
        '<div class="sum-doctor-profile__content">' +
          '<div class="sum-doctor-profile__layout">' +
            '<div class="sum-doctor-profile__main">' +
              '<h3 class="sum-doctor-profile__heading">About</h3>' +
              '<p class="sum-doctor-profile__bio">' + escapeHtml(bio).replace(/\n/g, '<br>') + '</p>' +
            '</div>' +
            '<ul class="sum-doctor-profile__facts sum-doctor-profile__facts--inline">' +
              '<li><strong>Department</strong><span>' + escapeHtml(doc.department) + '</span></li>' +
              (doc.qualification ? '<li><strong>Qualification</strong><span>' + escapeHtml(doc.qualification) + '</span></li>' : '') +
              '<li><strong>Hospital</strong><span>SUM Ultimate Medicare, Bhubaneswar</span></li>' +
            '</ul>' +
          '</div>' +
          '<p class="sum-doctor-profile__permalink"><a href="' + escapeHtml(profileUrl(id)) + '">Open full profile page <i class="fas fa-external-link-alt" aria-hidden="true"></i></a></p>' +
        '</div>' +
      '</article>';

    return true;

  }



  function escapeHtml(str) {

    return String(str)

      .replace(/&/g, '&amp;')

      .replace(/</g, '&lt;')

      .replace(/>/g, '&gt;')

      .replace(/"/g, '&quot;');

  }



  function openModal(id, push) {

    if (!renderProfile(id)) return;

    modal.classList.add('is-open');

    modal.setAttribute('aria-hidden', 'false');

    document.body.classList.add('sum-doctor-modal-open');

    if (push !== false) {

      history.pushState({ sumDoctorModal: true, listUrl: listReturnUrl }, '', profileUrl(id));

    }

    if (closeBtn) closeBtn.focus();

  }



  function closeModal(restoreUrl) {

    modal.classList.remove('is-open');

    modal.setAttribute('aria-hidden', 'true');

    document.body.classList.remove('sum-doctor-modal-open');

    if (restoreUrl !== false && history.state && history.state.listUrl) {

      history.pushState(null, '', history.state.listUrl);

    }

  }



  grid.addEventListener('click', function (e) {

    var link = e.target.closest('.sum-doctor-card--link');

    if (!link) return;

    if (e.metaKey || e.ctrlKey || e.shiftKey || e.button === 1) return;

    var id = link.getAttribute('data-doctor-id');

    if (!id || !window.sumDoctorsById[id]) return;

    e.preventDefault();

    openModal(id, true);

  });



  if (closeBtn) {

    closeBtn.addEventListener('click', function () {

      if (history.state && history.state.sumDoctorModal) {

        history.back();

      } else {

        closeModal(false);

      }

    });

  }



  if (backdrop) {

    backdrop.addEventListener('click', function () {

      if (history.state && history.state.sumDoctorModal) {

        history.back();

      } else {

        closeModal(false);

      }

    });

  }



  document.addEventListener('keydown', function (e) {

    if (e.key === 'Escape' && modal.classList.contains('is-open')) {

      if (history.state && history.state.sumDoctorModal) {

        history.back();

      } else {

        closeModal(false);

      }

    }

  });



  window.addEventListener('popstate', function () {

    var path = window.location.pathname || '';

    var idFromPath = doctorIdFromLocation();



    if (isDoctorProfilePath(path) && idFromPath && window.sumDoctorsById[idFromPath]) {

      openModal(idFromPath, false);

      return;

    }

    closeModal(false);

  });



  var openId = doctorIdFromLocation();

  if (openId && window.sumDoctorsById[openId] && window.location.pathname.indexOf('doctor.php') !== -1) {

    openModal(openId, false);

    history.replaceState({ sumDoctorModal: true, listUrl: listReturnUrl }, '', profileUrl(openId));

  }

})();

