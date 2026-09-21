(function () {
  // Mobile sidebar toggles
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('mobileOverlay');
  const toggle = document.getElementById('menuToggle');
  const close = document.getElementById('sidebarClose');

  const setSidebarOpen = (open) => {
    sidebar?.classList.toggle('open', open);
    overlay?.classList.toggle('show', open);
    document.body.classList.toggle('nav-open', open);
  };

  toggle?.addEventListener('click', () => setSidebarOpen(true));
  close?.addEventListener('click', () => setSidebarOpen(false));
  overlay?.addEventListener('click', () => setSidebarOpen(false));

  // Tab switching for User Growth Chart on main dashboard
  const filterTabs = document.querySelectorAll('.filter-tab');
  const growthPath = document.querySelector('.growth-svg path[stroke]');
  const growthArea = document.querySelector('.growth-svg path[fill^="url"]');
  const circles = document.querySelectorAll('.growth-svg circle');

  const chartPresets = {
    '7D': {
      path: 'M 10,100 C 80,80 120,60 180,45 C 240,30 300,50 370,35 C 420,25 460,20 490,15',
      area: 'M 10,100 C 80,80 120,60 180,45 C 240,30 300,50 370,35 C 420,25 460,20 490,15 L 490,160 L 10,160 Z',
      points: [[10, 100], [135, 60], [260, 40], [385, 30], [490, 15]]
    },
    '30D': {
      path: 'M 10,135 C 70,120 100,128 135,115 C 170,102 210,108 260,80 C 310,52 350,75 385,62 C 430,48 460,35 490,28',
      area: 'M 10,135 C 70,120 100,128 135,115 C 170,102 210,108 260,80 C 310,52 350,75 385,62 C 430,48 460,35 490,28 L 490,160 L 10,160 Z',
      points: [[10, 135], [135, 115], [260, 80], [385, 62], [490, 28]]
    },
    '3M': {
      path: 'M 10,150 C 90,140 140,110 200,95 C 260,80 320,65 390,50 C 440,38 470,30 490,20',
      area: 'M 10,150 C 90,140 140,110 200,95 C 260,80 320,65 390,50 C 440,38 470,30 490,20 L 490,160 L 10,160 Z',
      points: [[10, 150], [135, 120], [260, 90], [385, 55], [490, 20]]
    },
    '1Y': {
      path: 'M 10,155 C 80,150 150,130 220,100 C 280,75 350,45 400,35 C 440,28 470,22 490,18',
      area: 'M 10,155 C 80,150 150,130 220,100 C 280,75 350,45 400,35 C 440,28 470,22 490,18 L 490,160 L 10,160 Z',
      points: [[10, 155], [135, 135], [260, 95], [385, 40], [490, 18]]
    }
  };

  filterTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      filterTabs.forEach((t) => t.classList.remove('active'));
      tab.classList.add('active');
      const key = tab.textContent.trim();
      const preset = chartPresets[key];
      if (preset && growthPath && growthArea) {
        growthPath.setAttribute('d', preset.path);
        growthArea.setAttribute('d', preset.area);
        preset.points.forEach((pt, idx) => {
          if (circles[idx]) {
            circles[idx].setAttribute('cx', pt[0]);
            circles[idx].setAttribute('cy', pt[1]);
          }
        });
      }
    });
  });

  // Global Professional Modal Management
  window.openModal = function (id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('active');
    document.body.classList.add('modal-open');

    // Auto-focus first visible input for keyboard UX
    setTimeout(() => {
      const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
      if (firstInput && typeof firstInput.focus === 'function') {
        firstInput.focus();
      }
    }, 60);
  };

  window.closeModal = function (id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('active');
    if (!document.querySelector('.modal-overlay.active')) {
      document.body.classList.remove('modal-open');
    }
  };

  // Close modals on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const activeModals = document.querySelectorAll('.modal-overlay.active');
      activeModals.forEach((m) => m.classList.remove('active'));
      document.body.classList.remove('modal-open');
    }
  });

  // Close modal when clicking directly on overlay backdrop
  document.addEventListener('click', (e) => {
    if (e.target && e.target.classList.contains('modal-overlay')) {
      e.target.classList.remove('active');
      if (!document.querySelector('.modal-overlay.active')) {
        document.body.classList.remove('modal-open');
      }
    }
  });
})();
