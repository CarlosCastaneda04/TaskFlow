import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';

type Task = {
    id: number;
    title: string;
    status: string;
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

    const openModal = (project: Project) => {
        setSelectedProject(project);
        setIsOpen(true);
    };

    const closeModal = () => {
        setIsOpen(false);
        setSelectedProject(null);
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
                            className="bg-white dark:bg-gray-900 p-4 rounded-2xl shadow hover:shadow-lg transition cursor-pointer"
                            onClick={() => openModal(project)}
                        >
                            <h2 className="text-xl font-semibold">{project.name}</h2>
                            <p className="text-sm text-gray-600 dark:text-gray-300">{project.description || 'Sin descripción'}</p>
                            <p className="mt-2 text-xs text-gray-500">{project.tasks.length} tareas</p>
                        </div>
                    ))}
                </div>
            </div>

            {/* Modal */}
            <Dialog open={isOpen} onOpenChange={closeModal}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Tareas de: {selectedProject?.name}</DialogTitle>
                    </DialogHeader>
                    <div className="mt-2 space-y-2">
                        {selectedProject?.tasks.length ? (
                            selectedProject.tasks.map(task => (
                                <div
                                    key={task.id}
                                    className="p-2 border rounded-lg dark:border-gray-700"
                                >
                                    <p className="font-medium">{task.title}</p>
                                    <p className="text-sm text-gray-500">Estado: {task.status}</p>
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
