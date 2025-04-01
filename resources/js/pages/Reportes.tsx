import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { Pie, Bar } from 'react-chartjs-2';
import {
    Chart as ChartJS,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend
} from 'chart.js';
import { Button } from '@/components/ui/button';

ChartJS.register(BarElement, ArcElement, CategoryScale, LinearScale, Tooltip, Legend);

type Task = {
    status: string;
    priority: 'Alta' | 'Media' | 'Baja';
};

type Project = {
    id: number;
    name: string;
    tasks: Task[];
};

type PageProps = {
    user: {
        name: string;
    };
    projects: Project[];
};

export default function Reportes() {
    const { user, projects } = usePage<PageProps>().props;

    const allTasks = projects.flatMap(p => p.tasks);

    const estadoData = {
        labels: ['Pendiente', 'En Progreso', 'Completado'],
        datasets: [
            {
                label: 'Tareas por Estado',
                data: [
                    allTasks.filter(t => t.status === 'Pendiente').length,
                    allTasks.filter(t => t.status === 'En Progreso').length,
                    allTasks.filter(t => t.status === 'Completado').length,
                ],
                backgroundColor: ['#facc15', '#60a5fa', '#34d399'],
            },
        ],
    };

    const prioridadData = {
        labels: ['Alta', 'Media', 'Baja'],
        datasets: [
            {
                label: 'Tareas por Prioridad',
                data: [
                    allTasks.filter(t => t.priority === 'Alta').length,
                    allTasks.filter(t => t.priority === 'Media').length,
                    allTasks.filter(t => t.priority === 'Baja').length,
                ],
                backgroundColor: ['#ef4444', '#facc15', '#60a5fa'],
            },
        ],
    };

    return (
        <AppLayout>
            <Head title="Reporte de Proyectos y Tareas" />
            <div className="p-6 space-y-8 max-w-4xl mx-auto">
                <h1 className="text-3xl font-bold">Reportes de {user.name}</h1>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div className="p-4 bg-white dark:bg-gray-900 rounded-xl shadow text-center">
                        <h2 className="text-lg font-semibold">Total de Proyectos</h2>
                        <p className="text-2xl">{projects.length}</p>
                    </div>
                    <div className="p-4 bg-white dark:bg-gray-900 rounded-xl shadow text-center">
                        <h2 className="text-lg font-semibold">Total de Tareas</h2>
                        <p className="text-2xl">{allTasks.length}</p>
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-900 p-4 rounded-xl shadow">
                    <h2 className="text-xl font-semibold mb-4">Gráfico: Tareas por Estado</h2>
                    <Pie data={estadoData} />
                </div>

                <div className="bg-white dark:bg-gray-900 p-4 rounded-xl shadow">
                    <h2 className="text-xl font-semibold mb-4">Gráfico: Tareas por Prioridad</h2>
                    <Bar data={prioridadData} />
                </div>

                <div className="flex justify-end gap-2 mt-6">
                    <Button onClick={() => window.location.href = '/reportes/pdf'}>
                        Exportar PDF
                    </Button>
                    
                </div>
            </div>
        </AppLayout>
    );
}
