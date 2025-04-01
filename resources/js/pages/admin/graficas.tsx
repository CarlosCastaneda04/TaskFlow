import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { Cell, Legend, Pie, PieChart, ResponsiveContainer, Tooltip } from 'recharts';

type PageProps = {
    tareasPorProyectoYEmpleado: Record<string, Record<string, number>>;
    tareasPorEmpleado: { user: string; count: number }[];
};

const COLORS = ['#8884d8', '#82ca9d', '#ffc658', '#ff7f50', '#a3a3ff', '#ff69b4'];

export default function Graficas() {
    const { tareasPorProyectoYEmpleado, tareasPorEmpleado } = usePage<PageProps>().props;

    return (
        <AppLayout>
            <Head title="Gráficas de Tareas" />
            <div className="space-y-10 p-4">
                <h1 className="text-3xl font-bold">Gráficas de Tareas</h1>

                {/* Total por empleado */}
                <div className="space-y-2">
                    <h2 className="text-xl font-semibold">Tareas Totales por Empleado</h2>
                    <ResponsiveContainer width="100%" height={300}>
                        <PieChart>
                            <Pie data={tareasPorEmpleado} dataKey="count" nameKey="user" cx="50%" cy="50%" outerRadius={100} label>
                                {tareasPorEmpleado.map((entry, index) => (
                                    <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                                ))}
                            </Pie>
                            <Tooltip />
                            <Legend />
                        </PieChart>
                    </ResponsiveContainer>
                </div>

                {/* Por proyecto */}
                <div className="space-y-6">
                    <h2 className="text-xl font-semibold">Tareas por Empleado por Proyecto</h2>
                    {Object.entries(tareasPorProyectoYEmpleado).map(([projectId, empleados], i) => {
                        const data = Object.entries(empleados).map(([userId, count]) => ({
                            name: `Empleado ${userId}`,
                            value: count,
                        }));

                        return (
                            <div key={i}>
                                <h3 className="text-md mb-2 font-semibold">Proyecto #{projectId}</h3>
                                <ResponsiveContainer width="100%" height={250}>
                                    <PieChart>
                                        <Pie data={data} dataKey="value" nameKey="name" cx="50%" cy="50%" outerRadius={80} label>
                                            {data.map((entry, index) => (
                                                <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                                            ))}
                                        </Pie>
                                        <Tooltip />
                                        <Legend />
                                    </PieChart>
                                </ResponsiveContainer>
                            </div>
                        );
                    })}
                </div>
            </div>
        </AppLayout>
    );
}
