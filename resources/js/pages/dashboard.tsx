import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

type User = {
    rol: 'admin' | 'cliente' | 'trabajador';
    // ... otras propiedades
};

type PageProps = {
    auth: {
        user: User;
    };
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const roleTitles = {
    admin: 'Administrador',
    cliente: 'Cliente',
    trabajador: 'Trabajador'
} as const;

type UserRole = keyof typeof roleTitles;

export default function Dashboard() {
    const { user } = usePage<PageProps>().props.auth;
    const userRole = user.rol as UserRole;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Dashboard - ${roleTitles[userRole]}`} />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-3xl font-bold">
                        Dashboard de {roleTitles[userRole]}
                    </h1>

                    <div className="flex gap-2">
                        {user.rol === 'cliente' && (
                            <>
                                <Link
                                    href="/projects/create"
                                    className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Crear Nuevo Proyecto
                                </Link>

                                <Link href="/tasks/create">
                                    <Button>
                                        Crear Tarea
                                    </Button>
                                </Link>

                                <Link href="/ver-proyectos-tareas">
                                    <Button variant="outline">
                                        Ver Proyectos y Tareas
                                    </Button>
                                </Link>


                            </>


                        )}

                    </div>
                </div>

                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    {/* ... tu contenido actual ... */}
                </div>
            </div>
        </AppLayout>
    );
}
