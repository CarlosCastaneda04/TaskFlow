import AppLayout from '@/layouts/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

type Project = {
    id: number;
    name: string;
    description?: string;
    fecha_cierre?: string;
};

type Props = {
    project: Project;
};

export default function EditarProyecto({ project }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: project.name,
        description: project.description || '',
        fecha_cierre: project.fecha_cierre || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/proyectos/${project.id}`);
    };

    return (
        <AppLayout>
            <Head title="Editar Proyecto" />
            <div className="p-8 md:p-12 max-w-4xl mx-auto space-y-10">
                <h1 className="text-4xl font-bold text-center">Editar Proyecto</h1>

                <form
                    onSubmit={handleSubmit}
                    className="space-y-8 bg-white dark:bg-gray-900 px-10 py-10 rounded-2xl shadow-md"
                >
                    <div className="space-y-3">
                        <label className="block text-lg font-semibold">Nombre</label>
                        <Input
                            className="w-full h-12 text-base"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        {errors.name && <p className="text-red-500 text-sm">{errors.name}</p>}
                    </div>

                    <div className="space-y-3">
                        <label className="block text-lg font-semibold">Descripción</label>
                        <textarea
                            className="w-full rounded-lg border px-4 py-4 text-base dark:bg-gray-800 dark:text-white min-h-[160px]"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                        />
                    </div>

                    <div className="space-y-3">
                        <label className="block text-lg font-semibold">Fecha de cierre</label>
                        <Input
                            className="w-full h-12 text-base"
                            type="date"
                            value={data.fecha_cierre}
                            onChange={(e) => setData('fecha_cierre', e.target.value)}
                        />
                    </div>

                    <div className="pt-6">
                        <Button className="w-full h-12 text-lg" type="submit" disabled={processing}>
                            Guardar Cambios
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
