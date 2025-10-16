import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Chart.js
import {
    Chart,
    LineController,
    BarController,
    DoughnutController,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Tooltip,
    Legend,
    Filler
} from 'chart.js';

Chart.register(
    LineController,
    BarController,
    DoughnutController,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Tooltip,
    Legend,
    Filler
);

// Make Chart available globally
window.Chart = Chart;

// Chart.js custom configuration
const chartColors = {
    violet: {
        50: '#f1eeff',
        100: '#e6e1ff',
        200: '#d2cbff',
        300: '#b7acff',
        400: '#9c8cff',
        500: '#8470ff',
        600: '#755ff8',
        700: '#5d47de',
        800: '#4634b1',
        900: '#2f227c'
    },
    green: {
        500: '#3ec972',
        600: '#34bd68'
    },
    red: {
        500: '#ff5656',
        600: '#fa4949'
    },
    gray: {
        100: '#f3f4f6',
        200: '#e5e7eb',
        300: '#bfc4cd',
        400: '#9ca3af',
        500: '#6b7280',
        600: '#4b5563',
        700: '#374151',
        800: '#1f2937'
    }
};

window.chartColors = chartColors;

// Tailwind colors
const tailwindConfig = () => {
    // Define chart colors
    return {
        violet: chartColors.violet,
        green: chartColors.green,
        red: chartColors.red,
        gray: chartColors.gray
    };
};

window.tailwindConfig = tailwindConfig;

// Format currency
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};

// Format number
window.formatNumber = function(number) {
    return new Intl.NumberFormat('en-US').format(number);
};

