// Función para cambiar a la vista del módulo seleccionado
function loadModule(moduleId) {
    const content = document.getElementById('content');
    const backButton = document.getElementById('back-button');

    let moduleContent = {
        'usuarios': '<h1>Gestión de Usuarios y Roles</h1><p>Aquí podrás gestionar los usuarios y sus permisos.</p>',
        'recursos': '<h1>Módulo de Recursos Humanos</h1><p>Gestiona la información de los empleados.</p>',
        'inventario': '<h1>Módulo de Inventario</h1><p>Controla el inventario de la empresa.</p>',
        'transportes': '<h1>Módulo de Transportes</h1><p>Administra los vehículos y rutas.</p>',
        'herramientas': '<h1>Módulo de Herramientas y Equipos</h1><p>Gestiona las herramientas disponibles.</p>',
        'compras': '<h1>Módulo de Compras y Proveedores</h1><p>Realiza órdenes de compra y controla proveedores.</p>',
        'proyectos': '<h1>Módulo de Proyectos</h1><p>Administra los proyectos en curso.</p>',
        'clientes': '<h1>Módulo de Plantas (Clientes)</h1><p>Gestiona la información de los clientes.</p>',
        'reportes': '<h1>Reportes y Análisis</h1><p>Genera reportes y estadísticas.</p>',
        'auditoria': '<h1>Módulo de Auditoría</h1><p>Realiza auditorías de procesos.</p>',
    };

    content.innerHTML = moduleContent[moduleId] || '<h1>Bienvenido al Dashboard</h1><p>Selecciona un módulo para continuar.</p>';
    backButton.classList.remove('hidden');
}

// Función para regresar al dashboard principal
function goBack() {
    document.getElementById('content').innerHTML = '<h1>Bienvenido al Dashboard</h1><p>Selecciona un módulo para continuar.</p>';
    document.getElementById('back-button').classList.add('hidden');
}

// Función para cerrar sesión
function logout() {
    alert('Sesión cerrada');
    window.location.href = '../bienvenida.html';
}

// Asignar eventos a los módulos
document.querySelectorAll('.module').forEach(module => {
    module.addEventListener('click', function () {
        loadModule(this.id);
    });
});
