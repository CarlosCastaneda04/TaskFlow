import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { Bar, Pie } from 'react-chartjs-2';
import {
    Chart as ChartJS,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    ArcElement,
} from 'chart.js';

ChartJS.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend, ArcElement);

type Task = {
    id: number;
    status: string;
    priority: 'Alta' | 'Media' | 'Baja';
};

type Project = {
    id: number;
    name: string;
    tasks: Task[];
};

type PageProps = {
    projects: Project[];
};

export default function Graficas() {
    const { projects } = usePage<PageProps>().props;

    // 📊 Datos para gráfico de barras: Tareas por proyecto
    const barData = {
        labels: projects.map(p => p.name),
        datasets: [
            {
                label: 'Tareas por Proyecto',
                data: projects.map(p => p.tasks.length),
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
            },
        ],
    };

    // 🧁 Datos para gráfico circular: Estado de tareas
    const allTasks = projects.flatMap(p => p.tasks);
    const estadoCounts = {
        Pendiente: allTasks.filter(t => t.status === 'Pendiente').length,
        'En Progreso': allTasks.filter(t => t.status === 'En Progreso').length,
        Completado: allTasks.filter(t => t.status === 'Completado').length,
    };

    const pieData = {
        labels: Object.keys(estadoCounts),
        datasets: [
            {
                label: 'Estado de Tareas',
                data: Object.values(estadoCounts),
                backgroundColor: ['#facc15', '#60a5fa', '#34d399'],
            },
        ],
    };

    // 📶 Datos para gráfico de barras: Prioridad de tareas
    const prioridadCounts = {
        Alta: allTasks.filter(t => t.priority === 'Alta').length,
        Media: allTasks.filter(t => t.priority === 'Media').length,
        Baja: allTasks.filter(t => t.priority === 'Baja').length,
    };

    const prioridadData = {
        labels: Object.keys(prioridadCounts),
        datasets: [
            {
                label: 'Tareas por Prioridad',
                data: Object.values(prioridadCounts),
                backgroundColor: ['#ef4444', '#facc15', '#60a5fa'],
            },
        ],
    };

    return (
        <AppLayout>
            <Head title="Gráficas" />
            <div className="p-6 space-y-8 max-w-4xl mx-auto">
                <h1 className="text-3xl font-bold text-center">Resumen Visual de Proyectos</h1>

                <div className="bg-white dark:bg-gray-900 p-4 rounded-xl shadow">
                    <h2 className="text-xl font-semibold mb-4">Tareas por Proyecto</h2>
                    <Bar data={barData} />
                </div>

                <div className="bg-white dark:bg-gray-900 p-4 rounded-xl shadow">
                    <h2 className="text-xl font-semibold mb-4">Estados de Tareas</h2>
                    <Pie data={pieData} />
                </div>

                <div className="bg-white dark:bg-gray-900 p-4 rounded-xl shadow">
                    <h2 className="text-xl font-semibold mb-4">Prioridad de Tareas</h2>
                    <Bar data={prioridadData} />
                </div>
            </div>
        </AppLayout>
    );
}
