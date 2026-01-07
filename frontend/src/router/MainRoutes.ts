const MainRoutes = {
  path: "/",
  meta: {
    requiresAuth: true,
  },
  //redirect: "/home",
  component: () => import("@/layouts/full/FullLayout.vue"),
  children: [
    {
      path: "home",
      name: "Home",
      component: () => import("@/views/Home.vue"),
    },
    
    // ==================== PROVEEDORES ====================
    {
      path: "suppliers",
      name: "Suppliers",
      component: () => import("@/views/suppliers/index.vue"),
    },
    {
      path: "suppliers/create",
      name: "CreateSupplier",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "suppliers/:id/edit",
      name: "EditSupplier",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "suppliers/:id",
      name: "SupplierDetail",
      component: () => import("@/views/Home.vue"),
    },
    
    // Contactos de proveedores
    {
      path: "supplier-contacts",
      name: "SupplierContacts",
      component: () => import("@/views/Home.vue"),
    },
    
    // Desempeño de proveedores
    {
      path: "supplier-performance",
      name: "SupplierPerformance",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== MATERIALES ====================
    {
      path: "materials",
      name: "Materials",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "materials/create",
      name: "MaterialCreate",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "materials/:id/edit",
      name: "MaterialEdit",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "materials/:id",
      name: "MaterialDetail",
      component: () => import("@/views/Home.vue"),
    },

    // Categorías de materiales
    {
      path: "material-categories",
      name: "MaterialCategories",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== REQUISICIONES ====================
    {
      path: "purchase-requisitions",
      name: "PurchaseRequisitions",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-requisitions/create",
      name: "PurchaseRequisitionCreate",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-requisitions/:id/edit",
      name: "PurchaseRequisitionEdit",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-requisitions/:id",
      name: "PurchaseRequisitionDetail",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== ÓRDENES DE COMPRA ====================
    {
      path: "purchase-orders",
      name: "PurchaseOrders",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-orders/create",
      name: "PurchaseOrderCreate",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-orders/:id/edit",
      name: "PurchaseOrderEdit",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "purchase-orders/:id",
      name: "PurchaseOrderDetail",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== RECEPCIONES ====================
    {
      path: "receipts",
      name: "Receipts",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "receipts/create",
      name: "ReceiptCreate",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "receipts/:id",
      name: "ReceiptDetail",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== INSPECCIONES DE CALIDAD ====================
    {
      path: "quality-inspections",
      name: "QualityInspections",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "quality-inspections/create",
      name: "QualityInspectionCreate",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "quality-inspections/:id",
      name: "QualityInspectionDetail",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== CATÁLOGOS ====================
    {
      path: "catalogs/currencies",
      name: "Currencies",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "catalogs/payment-terms",
      name: "PaymentTerms",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "catalogs/supplier-types",
      name: "SupplierTypes",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "catalogs/supplier-statuses",
      name: "SupplierStatuses",
      component: () => import("@/views/Home.vue"),
    },

    // ==================== REPORTES ====================
    {
      path: "reports/suppliers",
      name: "SupplierReports",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "reports/purchases",
      name: "PurchaseReports",
      component: () => import("@/views/Home.vue"),
    },
    {
      path: "reports/inventory",
      name: "InventoryReports",
      component: () => import("@/views/Home.vue"),
    },
  ],
};

export default MainRoutes;
