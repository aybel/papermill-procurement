import {
    LayoutDashboardIcon,
    UsersIcon,
    PackageIcon,
    ClipboardTextIcon,
    FileTextIcon,
    TruckDeliveryIcon,
    ShieldCheckIcon,
    SettingsIcon,
    ReportAnalyticsIcon,
    PhoneIcon,
    ChartLineIcon,
    CurrencyDollarIcon,
    TagIcon,
    CircleCheckIcon,
    PointIcon
} from 'vue-tabler-icons';

export interface menu {
    header?: string;
    title?: string;
    icon?: any;
    to?: string;
    chip?: string;
    chipColor?: string;
    chipBgColor?: string;
    chipVariant?: string;
    chipIcon?: string;
    children?: menu[];
    disabled?: boolean;
    type?: string;
    subCaption?: string;
    external?: boolean;
}

const sidebarItem: menu[] = [
    { header: 'Principal' },
    {
        title: 'Dashboard',
        icon: LayoutDashboardIcon,
        to: '/home',
        external: false
    },

    { header: 'Gestión de Proveedores' },
    {
        title: 'Proveedores',
        icon: UsersIcon,
        to: '/suppliers',
        external: false
    },
    {
        title: 'Contactos',
        icon: PhoneIcon,
        to: '/supplier-contacts',
        external: false
    },
    {
        title: 'Desempeño',
        icon: ChartLineIcon,
        to: '/supplier-performance',
        external: false
    },

    { header: 'Gestión de Materiales' },
    {
        title: 'Materiales',
        icon: PackageIcon,
        to: '/materials',
        external: false
    },
    {
        title: 'Categorías',
        icon: TagIcon,
        to: '/material-categories',
        external: false
    },

    { header: 'Procesos de Compra' },
    {
        title: 'Requisiciones',
        icon: ClipboardTextIcon,
        to: '/purchase-requisitions',
        external: false
    },
    {
        title: 'Órdenes de Compra',
        icon: FileTextIcon,
        to: '/purchase-orders',
        external: false
    },
    {
        title: 'Recepciones',
        icon: TruckDeliveryIcon,
        to: '/receipts',
        external: false
    },
    {
        title: 'Inspecciones de Calidad',
        icon: ShieldCheckIcon,
        to: '/quality-inspections',
        external: false
    },

    { header: 'Catálogos' },
    {
        title: 'Configuración',
        icon: SettingsIcon,
        to: '#',
        children: [
            {
                title: 'Monedas',
                icon: CurrencyDollarIcon,
                to: '/catalogs/currencies',
                external: false
            },
            {
                title: 'Términos de Pago',
                icon: ChartLineIcon,
                to: '/catalogs/payment-terms',
                external: false
            },
            {
                title: 'Tipos de Proveedor',
                icon: TagIcon,
                to: '/catalogs/supplier-types',
                external: false
            },
            {
                title: 'Estados de Proveedor',
                icon: CircleCheckIcon,
                to: '/catalogs/supplier-statuses',
                external: false
            }
        ]
    },

    { header: 'Reportes' },
    {
        title: 'Reportes',
        icon: ReportAnalyticsIcon,
        to: '#',
        children: [
            {
                title: 'Proveedores',
                icon: PointIcon,
                to: '/reports/suppliers',
                external: false
            },
            {
                title: 'Compras',
                icon: PointIcon,
                to: '/reports/purchases',
                external: false
            },
            {
                title: 'Inventario',
                icon: PointIcon,
                to: '/reports/inventory',
                external: false
            }
        ]
    },
    {
        header:'Usuarios'
    },
    {
        title: 'Gestión de Usuarios',
        icon: UsersIcon,
        to: '#',
        external: false,
        children: [
            {
                title: 'Autorizar Usuarios',  
                icon: UsersIcon,
                to: '/users',
                external: false
            },
            {
                title: 'Roles',
                icon: ShieldCheckIcon,
                to: '/roles',
                external: false
            }
        ]
    }
];

export default sidebarItem;
