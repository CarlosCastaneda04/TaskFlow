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

type PageProps = {
    auth: {
        user: User;
    };
    flash?: {
        success?: string;
    };
};

export default function CreateProject() {
    const { user } = usePage<PageProps>().props.auth;
    const { flash } = usePage<PageProps>().props;

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        start_date: '',
        end_date: '',
        user_id: user.id,
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

        post('/api/projects');
    };

    return (
        <AppLayout>
            <Head title="Crear nuevo proyecto" />
            <div className="max-w-2xl mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">Nuevo Proyecto</h1>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div>
                        <Label htmlFor="name">Nombre del Proyecto</Label>
                        <Input
                            id="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
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
                            <Label htmlFor="start_date">Fecha de Inicio</Label>
                            <Input
                                type="date"
                                id="start_date"
                                value={data.start_date}
                                min={today}
                                onChange={(e) => setData('start_date', e.target.value)}
                            />
                            {errors.start_date && <p className="text-red-500 text-sm mt-1">{errors.start_date}</p>}
                        </div>

                        <div>
                            <Label htmlFor="end_date">Fecha de Finalización</Label>
                            <Input
                                type="date"
                                id="end_date"
                                value={data.end_date}
                                min={data.start_date || today}
                                onChange={(e) => setData('end_date', e.target.value)}
                            />
                            {errors.end_date && <p className="text-red-500 text-sm mt-1">{errors.end_date}</p>}
                        </div>
                    </div>

                    <Button type="submit" disabled={processing}>
                        {processing ? 'Creando...' : 'Crear Proyecto'}
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
