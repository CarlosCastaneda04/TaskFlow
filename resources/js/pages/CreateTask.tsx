import { Head, useForm, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { format } from 'date-fns';
import { useEffect } from 'react';

// Tipos de usuario y props

type User = {
    id: number;
    rol: 'admin' | 'cliente' | 'trabajador';
};

type Project = {
    id: number;
    name: string;
};

type PageProps = {
    auth: {
        user: User;
    };
    flash?: {
        success?: string;
    };
    projects: Project[];
};

export default function CreateTask() {
    const { flash, projects } = usePage<PageProps>().props;

    const { data, setData, post, processing, errors } = useForm({
        project_id: '',
        title: '',
        description: '',
        status: 'Pendiente',
        priority: 'Media',
        deadline: '',
    });

    const today = format(new Date(), 'yyyy-MM-dd');

    useEffect(() => {
        if (flash?.success) {
            alert(flash.success);
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 1500);
        }
    }, [flash]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/tasks');

    };

    return (
        <AppLayout>
            <Head title="Crear nueva tarea" />
            <div className="max-w-2xl mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">Nueva Tarea</h1>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div>
                        <Label htmlFor="project_id">Proyecto</Label>
                        <select
                            id="project_id"
                            value={data.project_id}
                            onChange={(e) => setData('project_id', e.target.value)}
                            className="w-full border rounded p-2 bg-gray-800 text-white"
                        >
                            <option value="">Selecciona un proyecto</option>
                            {projects.map((project) => (
                                <option key={project.id} value={project.id}>
                                    {project.name}
                                </option>
                            ))}
                        </select>
                        {errors.project_id && <p className="text-red-500 text-sm mt-1">{errors.project_id}</p>}
                    </div>

                    <div>
                        <Label htmlFor="title">Título de la tarea</Label>
                        <Input
                            id="title"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                        />
                        {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
                    </div>

                    <div>
                        <Label htmlFor="description">Descripción</Label>
                        <Input
                            id="description"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                        />
                        {errors.description && <p className="text-red-500 text-sm mt-1">{errors.description}</p>}
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <Label htmlFor="deadline">Fecha Límite</Label>
                            <Input
                                type="date"
                                id="deadline"
                                value={data.deadline}
                                min={today}
                                onChange={(e) => setData('deadline', e.target.value)}
                            />
                            {errors.deadline && <p className="text-red-500 text-sm mt-1">{errors.deadline}</p>}
                        </div>

                        <div>
                            <Label htmlFor="priority">Prioridad</Label>
                            <select
                                id="priority"
                                value={data.priority}
                                onChange={(e) => setData('priority', e.target.value)}
                                className="w-full border rounded p-2 bg-gray-800 text-white"
                            >
                                <option value="Alta">Alta</option>
                                <option value="Media">Media</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                    </div>

                    <Button type="submit" disabled={processing}>
                        {processing ? 'Creando...' : 'Crear Tarea'}
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
