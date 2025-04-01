import AppLayout from '@/layouts/app-layout';
import { Head, usePage, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import Swal from 'sweetalert2';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';

type Task = {
    id: number;
    title: string;
    status: string;
    priority: 'Alta' | 'Media' | 'Baja';
    created_at: string;
};

type Project = {
    id: number;
    name: string;
    description?: string;
    tasks: Task[];
};

type PageProps = {
    projects: Project[];
};

export default function VerProjectsAndTask() {
    const { projects } = usePage<PageProps>().props;
    const [selectedProject, setSelectedProject] = useState<Project | null>(null);
    const [isOpen, setIsOpen] = useState(false);
    const [sortBy, setSortBy] = useState<'recientes' | 'antiguas' | 'prioridad'>('recientes');

    const openModal = (project: Project) => {
        setSelectedProject(project);
        setIsOpen(true);
        setSortBy('recientes');
    };

    const closeModal = () => {
        setIsOpen(false);
        setSelectedProject(null);
    };

    const handleDelete = (projectId: number) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este proyecto será eliminado permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(`/proyectos/${projectId}`, {
                    onSuccess: () => {
                        Swal.fire('Eliminado', 'El proyecto fue eliminado.', 'success');
                        setIsOpen(false);
                        setSelectedProject(null);
                    },
                });
            }
        });
    };

    const handleDeleteTask = (taskId: number) => {
        Swal.fire({
            title: '¿Eliminar tarea?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed && selectedProject) {
                router.delete(`/tareas/${taskId}`, {
                    onSuccess: () => {
                        Swal.fire('Eliminada', 'La tarea ha sido eliminada.', 'success');

                        // ✅ Actualizar tareas localmente sin recargar
                        const updatedTasks = selectedProject.tasks.filter(task => task.id !== taskId);
                        setSelectedProject({
                            ...selectedProject,
                            tasks: updatedTasks,
                        });
                    },
                });
            }
        });
    };

    const getSortedTasks = () => {
        if (!selectedProject) return [];

        const tasks = [...selectedProject.tasks];

        if (sortBy === 'recientes') {
            return tasks.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
        }

        if (sortBy === 'antiguas') {
            return tasks.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime());
        }

        if (sortBy === 'prioridad') {
            const prioridadOrden = { Alta: 1, Media: 2, Baja: 3 };
            return tasks.sort((a, b) => prioridadOrden[a.priority] - prioridadOrden[b.priority]);
        }

        return tasks;
    };

    return (
        <AppLayout>
            <Head title="Mis Proyectos y Tareas" />

            <div className="p-4 space-y-4">
                <h1 className="text-3xl font-bold">Mis Proyectos</h1>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {projects.map(project => (
                        <div
                            key={project.id}
                            className="bg-white dark:bg-gray-900 p-4 rounded-2xl shadow hover:shadow-lg transition"
                        >
                            <div className="cursor-pointer" onClick={() => openModal(project)}>
                                <h2 className="text-xl font-semibold">{project.name}</h2>
                                <p className="text-sm text-gray-600 dark:text-gray-300">
                                    {project.description || 'Sin descripción'}
                                </p>
                                <p className="mt-2 text-xs text-gray-500">{project.tasks.length} tareas</p>
                            </div>

                            <div className="mt-4 flex gap-2 justify-between">
                                <Link href={`/proyectos/${project.id}/editar`}>
                                    <Button variant="outline" size="sm">Editar</Button>
                                </Link>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    onClick={() => handleDelete(project.id)}
                                >
                                    Eliminar
                                </Button>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Modal de tareas */}
            <Dialog open={isOpen} onOpenChange={closeModal}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Tareas de: {selectedProject?.name}</DialogTitle>
                    </DialogHeader>

                    <div className="mb-4">
                        <label className="block mb-1 text-sm font-medium">Ordenar por:</label>
                        <select
                            className="w-full rounded border px-3 py-2 dark:bg-gray-800 dark:text-white"
                            value={sortBy}
                            onChange={(e) => setSortBy(e.target.value as 'recientes' | 'antiguas' | 'prioridad')}
                        >
                            <option value="recientes">Más recientes</option>
                            <option value="antiguas">Más antiguas</option>
                            <option value="prioridad">Prioridad (Alta a Baja)</option>
                        </select>
                    </div>

                    <div className="mt-2 space-y-2">
                        {getSortedTasks().length ? (
                            getSortedTasks().map(task => (
                                <div
                                    key={task.id}
                                    className="p-4 border rounded-lg dark:border-gray-700 space-y-1"
                                >
                                    <div className="flex justify-between items-start">
                                        <div>
                                            <p className="font-medium text-base">{task.title}</p>
                                            <p className="text-sm text-gray-500">Estado: {task.status}</p>
                                            <p className="text-sm text-gray-400">Prioridad: {task.priority}</p>
                                        </div>
                                        <div className="flex gap-1">
                                            <Link href={`/tareas/${task.id}/editar`}>
                                                <Button size="sm" variant="outline">
                                                    Editar
                                                </Button>
                                            </Link>
                                            <Button
                                                size="sm"
                                                variant="destructive"
                                                onClick={() => handleDeleteTask(task.id)}
                                            >
                                                Eliminar
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <p>No hay tareas en este proyecto.</p>
                        )}
                    </div>
                </DialogContent>
            </Dialog>
        </AppLayout>
    );
}
