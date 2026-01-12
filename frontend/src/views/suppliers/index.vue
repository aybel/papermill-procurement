<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { supplierService, type Supplier } from '@/services/supplierService';
import { PencilIcon, TrashIcon, PlusIcon } from 'vue-tabler-icons';
import { useRouter } from 'vue-router';

const router = useRouter();

const suppliers = ref<Supplier[]>([]);
const loading = ref(false);
const search = ref('');

const headers = [
    { title: 'ID', key: 'id', align: 'start' },
    { title: 'Código', key: 'code', align: 'start' },
    { title: 'Nombre', key: 'name' },
    { title: 'RFC', key: 'tax_id' },
    { title: 'Limite de crédito', key: 'credit_limit' },
    { title: 'Activo', key: 'active' },
    { title: 'Acciones', key: 'actions', sortable: false, align: 'center' }
];

const loadSuppliers = async () => {
    loading.value = true;
    try {
        const response = await supplierService.getAll();
        suppliers.value = response.data || response;
    } catch (error: any) {
        let message = 'Error al cargar proveedores';
        if (error.response && (error.response.status === 401 || error.response.status === 403)) {
            message = 'Sesión expirada o sin permisos. Por favor, inicia sesión nuevamente.';
            // Redirigir al login
            window.location.href = '/login';
        }
        alert(message);
        console.error(message, error);
    } finally {
        loading.value = false;
    }
};

const handleEdit = (item: Supplier) => {
    console.log('Editar proveedor:', item);
    // Implementar navegación a edición
    router.push({ name: 'SupplierEdit', params: { id: item.id } });
};

const handleDelete = async (item: Supplier) => {
    if (confirm(`¿Está seguro de eliminar al proveedor ${item.name}?`)) {
        try {
            await supplierService.delete(item.id);
            await loadSuppliers();
        } catch (error) {
            console.error('Error al eliminar proveedor:', error);
        }
    }
};

const handleCreate = () => {
    console.log('Crear nuevo proveedor');
    // Implementar navegación a creación
};

onMounted(() => {
    loadSuppliers();
});
</script>

<template>
    <v-card elevation="10" class="withbg">
        <v-card-item>
            <div class="d-sm-flex align-center justify-space-between pt-sm-2">
                <v-card-title class="text-h5">Gestión de Proveedores</v-card-title>
                <div class="my-sm-0 my-2">
                    <v-btn color="primary" @click="handleCreate">
                        <PlusIcon class="mr-2" size="20" />
                        Nuevo Proveedor
                    </v-btn>
                </div>
            </div>
        </v-card-item>

        <v-card-text>
            <v-row class="mb-4">
                <v-col cols="12" md="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-magnify" label="Buscar proveedor"
                        variant="outlined" density="compact" hide-details />
                </v-col>
            </v-row>

            <v-data-table :headers="headers" :items="suppliers" :search="search" :loading="loading" :items-per-page="10"
                class="elevation-1" loading-text="Cargando proveedores..."
                no-data-text="No hay proveedores registrados">
                <template v-slot:item.actions="{ item }">
                    <v-btn icon size="small" variant="text" color="primary" @click="handleEdit(item)">
                        <PencilIcon size="20" />
                    </v-btn>
                    <v-btn icon size="small" variant="text" color="error" @click="handleDelete(item)">
                        <TrashIcon size="20" />
                    </v-btn>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>