/**
 * Mosaic Admin Dashboard Template Scripts
 */

import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Sidebar state management
window.initSidebar = () => {
    return {
        sidebarOpen: false,
        sidebarExpanded: localStorage.getItem('sidebar-expanded') === 'true',
        init() {
            // Set sidebar expanded state from localStorage
            if (this.sidebarExpanded) {
                document.querySelector('body').classList.add('sidebar-expanded');
            }
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        toggleSidebarExpanded() {
            this.sidebarExpanded = !this.sidebarExpanded;
            localStorage.setItem('sidebar-expanded', this.sidebarExpanded);
            if (this.sidebarExpanded) {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        },
        closeSidebar() {
            this.sidebarOpen = false;
        }
    };
};

// Dark mode toggle
window.initDarkMode = () => {
    return {
        darkMode: localStorage.getItem('darkMode') === 'true' || 
                  (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        init() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            }
        },
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    };
};

// Dropdown menu
window.initDropdown = () => {
    return {
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        }
    };
};

// Modal
window.initModal = () => {
    return {
        open: false,
        show() {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        hide() {
            this.open = false;
            document.body.style.overflow = 'auto';
        }
    };
};

// Toast notifications
window.showToast = (message, type = 'success', duration = 3000) => {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all transform translate-x-0 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        setTimeout(() => toast.remove(), 300);
    }, duration);
};

// Search modal
window.initSearchModal = () => {
    return {
        open: false,
        query: '',
        results: [],
        show() {
            this.open = true;
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },
        hide() {
            this.open = false;
            this.query = '';
            this.results = [];
        },
        search() {
            // Implement search functionality
            console.log('Searching for:', this.query);
        }
    };
};

// Datepicker
window.initDatepicker = () => {
    return {
        open: false,
        selectedDate: new Date(),
        currentMonth: new Date(),
        toggle() {
            this.open = !this.open;
        },
        selectDate(date) {
            this.selectedDate = date;
            this.open = false;
        },
        prevMonth() {
            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() - 1);
        },
        nextMonth() {
            this.currentMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + 1);
        }
    };
};

// Tabs
window.initTabs = () => {
    return {
        activeTab: 0,
        setActiveTab(index) {
            this.activeTab = index;
        }
    };
};

// Accordion
window.initAccordion = () => {
    return {
        activeIndex: null,
        toggle(index) {
            this.activeIndex = this.activeIndex === index ? null : index;
        }
    };
};

// Table row selection
window.initTableSelection = () => {
    return {
        selectedRows: [],
        selectAll: false,
        toggleAll(rows) {
            if (this.selectAll) {
                this.selectedRows = rows.map(row => row.id);
            } else {
                this.selectedRows = [];
            }
        },
        toggleRow(id) {
            const index = this.selectedRows.indexOf(id);
            if (index > -1) {
                this.selectedRows.splice(index, 1);
            } else {
                this.selectedRows.push(id);
            }
        },
        isSelected(id) {
            return this.selectedRows.includes(id);
        }
    };
};

// Click outside directive
document.addEventListener('click', (event) => {
    const dropdowns = document.querySelectorAll('[x-data]');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target)) {
            const alpineData = Alpine.$data(dropdown);
            if (alpineData && typeof alpineData.close === 'function') {
                alpineData.close();
            }
        }
    });
});

// Initialize Chart.js if available
if (typeof Chart !== 'undefined') {
    // Set global Chart.js defaults
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#6b7280';
    Chart.defaults.plugins.legend.display = false;
    Chart.defaults.plugins.tooltip.backgroundColor = '#1f2937';
    Chart.defaults.plugins.tooltip.titleColor = '#f3f4f6';
    Chart.defaults.plugins.tooltip.bodyColor = '#d1d5db';
    Chart.defaults.plugins.tooltip.borderColor = '#374151';
    Chart.defaults.plugins.tooltip.borderWidth = 1;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
}

