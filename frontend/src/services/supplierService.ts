import api from '@/plugins/axios';

const API_URL = import.meta.env.VITE_API_URL+"/v1";

export interface Supplier {
    id: number;
    code:string,
    name: string;
    tax_id: string,
    supplier_type_id: number;
    supplier_status_id: number;
    primary_contact_id: number;
    quality_score: number;
    delivery_score: number;
    payment_terms_id: number;
    currency_id: number;
    credit_limit: number;
    notes: string;
    active: boolean;
    created_at: string;
    updated_at: string;
}

export const supplierService = {
    async getAll() {
        const response = await api.get(`${API_URL}/suppliers`);
        return response.data.data;
    },

    async getById(id: number) {
        const response = await api.get(`${API_URL}/suppliers/${id}`);
        return response.data.data;
    },

    async create(supplier: Partial<Supplier>) {
        const response = await api.post(`${API_URL}/suppliers`, supplier);
        return response.data.data;
    },

    async update(id: number, supplier: Partial<Supplier>) {
        const response = await api.put(`${API_URL}/suppliers/${id}`, supplier);
        return response.data.data;
    },

    async delete(id: number) {
        const response = await api.delete(`${API_URL}/suppliers/${id}`);
        return response.data.data;
    }
};