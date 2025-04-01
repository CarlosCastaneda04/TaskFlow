import AppLayout from '@/layouts/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

type Task = {
    id: number;
    title: string;
    status: 'Pendiente' | 'En Progreso' | 'Completado';
    priority: 'Alta' | 'Media' | 'Baja';
    deadline: string;
};

type Props = {
    task: Task;
};

export default function EditarTarea({ task }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        title: task.title,
        status: task.status,
        priority: task.priority,
        deadline: task.deadline,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/tareas/${task.id}`);
    };

    return (
        <AppLayout>
            <Head title="Editar Tarea" />
            <div className="p-8 max-w-xl mx-auto space-y-8">
                <h1 className="text-3xl font-bold text-center">Editar Tarea</h1>

                <form onSubmit={handleSubmit} className="space-y-6 bg-white dark:bg-gray-900 p-6 rounded-2xl shadow">
                    <div>
                        <label className="block mb-1 font-semibold">Título</label>
                        <Input
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                        />
                        {errors.title && <p className="text-red-500 text-sm">{errors.title}</p>}
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Estado</label>
                        <select
                            value={data.status}
                            onChange={(e) => setData('status', e.target.value as Task['status'])}
                            className="w-full rounded border px-3 py-2 dark:bg-gray-800 dark:text-white"
                        >
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Progreso">En Progreso</option>
                            <option value="Completado">Completado</option>
                        </select>
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Prioridad</label>
                        <select
                            value={data.priority}
                            onChange={(e) => setData('priority', e.target.value as Task['priority'])}
                            className="w-full rounded border px-3 py-2 dark:bg-gray-800 dark:text-white"
                        >
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>

                    <div>
                        <label className="block mb-1 font-semibold">Fecha límite</label>
                        <Input
                            type="date"
                            value={data.deadline}
                            onChange={(e) => setData('deadline', e.target.value)}
                        />
                    </div>

                    <div className="pt-4">
                        <Button type="submit" className="w-full h-12 text-lg" disabled={processing}>
                            Guardar Cambios
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
