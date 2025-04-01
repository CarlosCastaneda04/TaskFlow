import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { useState } from 'react';
import Swal from 'sweetalert2';

type Task = {
    id: number;
    title: string;
    status: string;
    priority: 'Alta' | 'Media' | 'Baja';
    created_at: string;
    assigned_to?: number | null;
};

type Project = {
    id: number;
    name: string;
    description?: string;
    tasks: Task[];
};

type User = {
    id: number;
    name: string;
    rol: string;
};

type PageProps = {
    auth: {
        user: User;
    };
    projects: Project[];
    users: User[];
};

export default function VerProjectsAndTask() {
    const { projects, users, auth } = usePage<PageProps>().props;
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
                        const updatedTasks = selectedProject.tasks.filter((task) => task.id !== taskId);
                        setSelectedProject({ ...selectedProject, tasks: updatedTasks });
                    },
                });
            }
        });
    };
    const assignTaskToUser = (taskId: number, userId: number) => {
        router.put(
            `/tareas/${taskId}/asignar`,
            { user_id: userId },
            {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: '¡Asignado!',
                        text: 'La tarea fue asignada correctamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    if (selectedProject) {
                        const updatedTasks = selectedProject.tasks.map((task) =>
                            task.id === taskId ? { ...task, assigned_to: userId, status: 'En Progreso' } : task,
                        );
                        setSelectedProject({
                            ...selectedProject,
                            tasks: updatedTasks,
                        });
                    }
                },
            },
        );
    };

    const updateTaskStatus = (taskId: number, status: string) => {
        router.put(
            `/tareas/${taskId}/estado`,
            { status },
            {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: '¡Actualizado!',
                        text: 'El estado de la tarea fue actualizado correctamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    if (selectedProject) {
                        const updatedTasks = selectedProject.tasks.map((task) => (task.id === taskId ? { ...task, status } : task));
                        setSelectedProject({
                            ...selectedProject,
                            tasks: updatedTasks,
                        });
                    }
                },
            },
        );
    };

    const getSortedTasks = () => {
        if (!selectedProject) return [];
        const tasks = [...selectedProject.tasks];
        if (sortBy === 'recientes') return tasks.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
        if (sortBy === 'antiguas') return tasks.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime());
        if (sortBy === 'prioridad') {
            const prioridadOrden = { Alta: 1, Media: 2, Baja: 3 };
            return tasks.sort((a, b) => prioridadOrden[a.priority] - prioridadOrden[b.priority]);
        }
        return tasks;
    };

    return (
        <AppLayout>
            <Head title="Proyectos y Tareas" />

            <div className="space-y-4 p-4">
                <h1 className="text-3xl font-bold">Proyectos</h1>

                <div className="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    {projects.map((project) => (
                        <div key={project.id} className="rounded-2xl bg-white p-4 shadow transition hover:shadow-lg dark:bg-gray-900">
                            <div className="cursor-pointer" onClick={() => openModal(project)}>
                                <h2 className="text-xl font-semibold">{project.name}</h2>
                                <p className="text-sm text-gray-600 dark:text-gray-300">{project.description || 'Sin descripción'}</p>
                                <p className="mt-2 text-xs text-gray-500">{project.tasks.length} tareas</p>
                            </div>

                            <div className="mt-4 flex justify-between gap-2">
                                <Link href={`/proyectos/${project.id}/editar`}>
                                    <Button variant="outline" size="sm">
                                        Editar
                                    </Button>
                                </Link>
                                <Button variant="destructive" size="sm" onClick={() => handleDelete(project.id)}>
                                    Eliminar
                                </Button>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            <Dialog open={isOpen} onOpenChange={closeModal}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Tareas de: {selectedProject?.name}</DialogTitle>
                    </DialogHeader>

                    <div className="mb-4">
                        <label className="mb-1 block text-sm font-medium">Ordenar por:</label>
                        <select
                            className="w-full rounded border px-3 py-2 dark:bg-gray-800 dark:text-white"
                            value={sortBy}
                            onChange={(e) => setSortBy(e.target.value as any)}
                        >
                            <option value="recientes">Más recientes</option>
                            <option value="antiguas">Más antiguas</option>
                            <option value="prioridad">Prioridad (Alta a Baja)</option>
                        </select>
                    </div>

                    <div className="mt-2 space-y-2">
                        {getSortedTasks().length ? (
                            getSortedTasks().map((task) => (
                                <div key={task.id} className="space-y-1 rounded-lg border p-4 dark:border-gray-700">
                                    <div className="flex items-start justify-between">
                                        <div>
                                            <p className="text-base font-medium">{task.title}</p>
                                            <p className="text-sm text-gray-500">Estado: {task.status}</p>
                                            <p className="text-sm text-gray-400">Prioridad: {task.priority}</p>

                                            {auth.user.rol === 'admin' && (
                                                <div className="space-y-2 pt-2">
                                                    <div>
                                                        <label className="mb-1 block text-sm font-medium">Asignar a empleado:</label>
                                                        <select
                                                            value={task.assigned_to ?? ''}
                                                            onChange={(e) => assignTaskToUser(task.id, parseInt(e.target.value))}
                                                            className="w-full rounded border px-3 py-1 dark:bg-gray-800 dark:text-white"
                                                        >
                                                            <option value="">Seleccionar empleado</option>
                                                            {users.map((user) => (
                                                                <option key={user.id} value={user.id}>
                                                                    {user.name}
                                                                </option>
                                                            ))}
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label className="mb-1 block text-sm font-medium">Cambiar estado:</label>
                                                        <select
                                                            value={task.status}
                                                            onChange={(e) => updateTaskStatus(task.id, e.target.value)}
                                                            className="w-full rounded border px-3 py-1 dark:bg-gray-800 dark:text-white"
                                                        >
                                                            <option value="Pendiente">Pendiente</option>
                                                            <option value="En Progreso">En Progreso</option>
                                                            <option value="Completado">Completado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            )}
                                        </div>

                                        <div className="flex gap-1">
                                            <Link href={`/tareas/${task.id}/editar`}>
                                                <Button size="sm" variant="outline">
                                                    Editar
                                                </Button>
                                            </Link>
                                            <Button size="sm" variant="destructive" onClick={() => handleDeleteTask(task.id)}>
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
