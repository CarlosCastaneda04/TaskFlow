import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

type User = {
    rol: 'admin' | 'cliente' | 'trabajador';
};

type Project = {
    id: number;
    name: string;
    description: string;
};

type PageProps = {
    auth: {
        user: User;
    };
    projects?: Project[];
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
    trabajador: 'Trabajador',
} as const;

type UserRole = keyof typeof roleTitles;

export default function Dashboard() {
    const { user } = usePage<PageProps>().props.auth;
    const { projects = [] } = usePage<PageProps>().props;

    const userRole = user.rol as UserRole;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Dashboard - ${roleTitles[userRole]}`} />

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-3xl font-bold">Dashboard de {roleTitles[userRole]}</h1>

                    <div className="flex gap-2">
                        {user.rol === 'cliente' && (
                            <>
                                <Link
                                    href="/projects/create"
                                    className="rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
                                >
                                    Crear Proyecto
                                </Link>

                                <Link href="/tasks/create">
                                    <Button>Crear Tarea</Button>
                                </Link>

                                <Link href="/ver-proyectos-tareas">
                                    <Button variant="outline">Ver Proyectos y Tareas</Button>
                                </Link>

                                <Link href="/graficas">
                                    <Button variant="outline">Ver Gráficas</Button>
                                </Link>

                                <Link href="/reportes">
                                    <Button variant="outline">Ver Reportes</Button>
                                </Link>
                            </>
                        )}

                        {user.rol === 'admin' && (
                            <>
                                <Link href="/admin/ver-proyectos-tareas">
                                    <Button variant="outline">Ver Proyectos y Tareas</Button>
                                </Link>

                                <Link href="/admin/graficas">
                                    <Button variant="outline">Ver Gráficas</Button>
                                </Link>

                                <Link href="/admin/reportes">
                                    <Button variant="outline">Ver Reportes</Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>

                {/* BLOQUE PARA ADMIN */}
                {user.rol === 'admin' && (
                    <div className="space-y-4">
                        <h2 className="text-2xl font-semibold">Proyectos disponibles</h2>

                        <div className="grid gap-4">
                            {projects.map((project) => (
                                <Link
                                    key={project.id}
                                    href={`/admin/proyectos/${project.id}/tareas`}
                                    className="block rounded-lg border p-4 shadow transition hover:bg-gray-100 dark:hover:bg-gray-800"
                                >
                                    <h3 className="text-lg font-bold">{project.name}</h3>
                                    <p className="text-muted-foreground text-sm">{project.description}</p>
                                </Link>
                            ))}
                        </div>
                    </div>
                )}

                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    {/* ... tu contenido actual ... */}
                </div>
            </div>
        </AppLayout>
    );
}
