<template>
  <v-container fluid>
    <!-- Bienvenida -->
    <v-row>
      <v-col cols="12">
        <v-card class="mb-6 pa-4" color="primary" dark>
          <v-card-title class="text-h4 font-weight-bold">
            Sistema de Compras - Papermill Procurement
          </v-card-title>
          <v-card-subtitle class="text-h6 mt-2">
            Gestión integral de proveedores, materiales y órdenes de compra
          </v-card-subtitle>
        </v-card>
      </v-col>
    </v-row>

    <!-- KPIs principales -->
    <v-row>
      <v-col cols="12" md="3">
        <v-card class="text-center pa-4" elevation="2">
          <v-icon size="48" color="primary" class="mb-2">mdi-account-group</v-icon>
          <div class="text-h3 font-weight-bold">{{ stats.suppliers }}</div>
          <div class="text-subtitle-1 text-grey">Proveedores Activos</div>
          <v-btn variant="text" color="primary" :to="{ name: 'Suppliers' }" class="mt-2">
            Ver todos
          </v-btn>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="text-center pa-4" elevation="2">
          <v-icon size="48" color="success" class="mb-2">mdi-file-document-outline</v-icon>
          <div class="text-h3 font-weight-bold">{{ stats.purchaseOrders }}</div>
          <div class="text-subtitle-1 text-grey">Órdenes de Compra</div>
          <v-btn variant="text" color="success" :to="{ name: 'PurchaseOrders' }" class="mt-2">
            Ver todas
          </v-btn>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="text-center pa-4" elevation="2">
          <v-icon size="48" color="warning" class="mb-2">mdi-package-variant</v-icon>
          <div class="text-h3 font-weight-bold">{{ stats.materials }}</div>
          <div class="text-subtitle-1 text-grey">Materiales en Stock</div>
          <v-btn variant="text" color="warning" :to="{ name: 'Materials' }" class="mt-2">
            Ver inventario
          </v-btn>
        </v-card>
      </v-col>

      <v-col cols="12" md="3">
        <v-card class="text-center pa-4" elevation="2">
          <v-icon size="48" color="info" class="mb-2">mdi-clipboard-check-outline</v-icon>
          <div class="text-h3 font-weight-bold">{{ stats.requisitions }}</div>
          <div class="text-subtitle-1 text-grey">Requisiciones Pendientes</div>
          <v-btn variant="text" color="info" :to="{ name: 'PurchaseRequisitions' }" class="mt-2">
            Ver requisiciones
          </v-btn>
        </v-card>
      </v-col>
    </v-row>

    <!-- Accesos rápidos -->
    <v-row class="mt-4">
      <v-col cols="12">
        <v-card>
          <v-card-title class="text-h5 font-weight-bold">
            <v-icon class="mr-2">mdi-lightning-bolt</v-icon>
            Accesos Rápidos
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-row>
              <!-- Gestión de Proveedores -->
              <v-col cols="12" md="4">
                <v-list>
                  <v-list-subheader class="text-h6 font-weight-bold text-primary">
                    Proveedores
                  </v-list-subheader>
                  <v-list-item :to="{ name: 'Suppliers' }" prepend-icon="mdi-account-group">
                    <v-list-item-title>Lista de Proveedores</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'SupplierContacts' }" prepend-icon="mdi-card-account-phone">
                    <v-list-item-title>Contactos</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'SupplierPerformance' }" prepend-icon="mdi-chart-line">
                    <v-list-item-title>Desempeño</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-col>

              <!-- Gestión de Materiales -->
              <v-col cols="12" md="4">
                <v-list>
                  <v-list-subheader class="text-h6 font-weight-bold text-success">
                    Inventario
                  </v-list-subheader>
                  <v-list-item :to="{ name: 'Materials' }" prepend-icon="mdi-package-variant">
                    <v-list-item-title>Materiales</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'MaterialCategories' }" prepend-icon="mdi-shape">
                    <v-list-item-title>Categorías</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'Receipts' }" prepend-icon="mdi-truck-delivery">
                    <v-list-item-title>Recepciones</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-col>

              <!-- Proceso de Compras -->
              <v-col cols="12" md="4">
                <v-list>
                  <v-list-subheader class="text-h6 font-weight-bold text-warning">
                    Compras
                  </v-list-subheader>
                  <v-list-item :to="{ name: 'PurchaseRequisitions' }" prepend-icon="mdi-clipboard-text">
                    <v-list-item-title>Requisiciones</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'PurchaseOrders' }" prepend-icon="mdi-file-document">
                    <v-list-item-title>Órdenes de Compra</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{ name: 'QualityInspections' }" prepend-icon="mdi-shield-check">
                    <v-list-item-title>Inspecciones de Calidad</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Catálogos del Sistema -->
    <v-row class="mt-4">
      <v-col cols="12">
        <v-card>
          <v-card-title class="text-h5 font-weight-bold">
            <v-icon class="mr-2">mdi-cog</v-icon>
            Catálogos y Configuración
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-row>
              <v-col cols="6" md="3">
                <v-btn block variant="outlined" :to="{ name: 'Currencies' }" prepend-icon="mdi-currency-usd">
                  Monedas
                </v-btn>
              </v-col>
              <v-col cols="6" md="3">
                <v-btn block variant="outlined" :to="{ name: 'PaymentTerms' }" prepend-icon="mdi-calendar-clock">
                  Términos de Pago
                </v-btn>
              </v-col>
              <v-col cols="6" md="3">
                <v-btn block variant="outlined" :to="{ name: 'SupplierTypes' }" prepend-icon="mdi-tag-multiple">
                  Tipos de Proveedor
                </v-btn>
              </v-col>
              <v-col cols="6" md="3">
                <v-btn block variant="outlined" :to="{ name: 'SupplierStatuses' }" prepend-icon="mdi-check-circle">
                  Estados de Proveedor
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Actividad reciente -->
    <v-row class="mt-4">
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="text-h6 font-weight-bold">
            <v-icon class="mr-2">mdi-clock-outline</v-icon>
            Actividad Reciente
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-timeline density="compact" side="end" class="mt-2">
              <v-timeline-item
                v-for="(activity, index) in recentActivity"
                :key="index"
                :dot-color="activity.color"
                size="small"
              >
                <template v-slot:opposite>
                  <div class="text-caption">{{ activity.time }}</div>
                </template>
                <div>
                  <div class="font-weight-bold">{{ activity.title }}</div>
                  <div class="text-caption">{{ activity.description }}</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="text-h6 font-weight-bold">
            <v-icon class="mr-2">mdi-alert</v-icon>
            Alertas y Notificaciones
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-list>
              <v-list-item
                v-for="(alert, index) in alerts"
                :key="index"
                :prepend-icon="alert.icon"
                :class="alert.class"
              >
                <v-list-item-title>{{ alert.title }}</v-list-item-title>
                <v-list-item-subtitle>{{ alert.message }}</v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

// Estados
const stats = ref({
  suppliers: 0,
  purchaseOrders: 0,
  materials: 0,
  requisitions: 0,
});

const recentActivity = ref([
  {
    time: 'Hace 5 min',
    title: 'Nueva orden de compra',
    description: 'PO-2025-0045 creada para Celulosa Internacional',
    color: 'success',
  },
  {
    time: 'Hace 1 hora',
    title: 'Recepción completada',
    description: 'Material SKU-1234 recibido y aprobado',
    color: 'primary',
  },
  {
    time: 'Hace 2 horas',
    title: 'Inspección de calidad',
    description: 'Inspección #INS-789 completada con resultado aprobado',
    color: 'info',
  },
  {
    time: 'Hace 3 horas',
    title: 'Nuevo proveedor',
    description: 'Fibras Naturales SA agregado al sistema',
    color: 'warning',
  },
]);

const alerts = ref([
  {
    icon: 'mdi-alert-circle',
    title: 'Stock bajo',
    message: '5 materiales por debajo del punto de reorden',
    class: 'text-warning',
  },
  {
    icon: 'mdi-clock-alert',
    title: 'Órdenes pendientes',
    message: '3 órdenes de compra esperan aprobación',
    class: 'text-info',
  },
  {
    icon: 'mdi-truck-delivery',
    title: 'Entregas retrasadas',
    message: '2 entregas vencieron la fecha esperada',
    class: 'text-error',
  },
]);

// Métodos
const loadStats = async () => {
  // Aquí se cargarían las estadísticas reales desde la API
  stats.value = {
    suppliers: 20,
    purchaseOrders: 45,
    materials: 156,
    requisitions: 8,
  };
};

onMounted(() => {
  loadStats();
});
</script>

<style scoped>
.v-card {
  transition: transform 0.2s;
}

.v-card:hover {
  transform: translateY(-2px);
}
</style>
