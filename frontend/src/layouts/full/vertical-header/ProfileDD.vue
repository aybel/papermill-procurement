<script setup lang="ts">
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();

const handleLogout = () => {
    authStore.logout();
};
</script>

<template>
    <!-- ---------------------------------------------- -->
    <!-- notifications DD -->
    <!-- ---------------------------------------------- -->
    <v-menu :close-on-content-click="false">
        <template v-slot:activator="{ props }">
            <v-btn class="profileBtn custom-hover-primary" variant="text" v-bind="props" icon>
                <v-avatar size="35">
                    <img src="@/assets/images/users/avatar-1.jpg" height="35" alt="user" />
                </v-avatar>
            </v-btn>
        </template>
        <v-sheet rounded="md" width="200" elevation="10" class="mt-2">
            <v-list class="py-0" lines="one" density="compact">
                <v-list-item value="item1" color="primary" >
                    <template v-slot:prepend>
                        <UserIcon stroke-width="1.5" size="20"/>
                    </template>
                    <v-list-item-title class="pl-4 text-body-1">Mi Perfil</v-list-item-title>
                </v-list-item>
                <v-list-item value="item2" color="primary">
                    <template v-slot:prepend>
                        <MailIcon stroke-width="1.5" size="20"/>
                    </template>
                    <v-list-item-title  class="pl-4 text-body-1">Mi Cuenta</v-list-item-title>
                </v-list-item>
                <v-list-item value="item3" color="primary"> 
                    <template v-slot:prepend>
                        <ListCheckIcon stroke-width="1.5"  size="20"/>
                    </template>
                    <v-list-item-title class="pl-4 text-body-1">Mis Tareas</v-list-item-title>
                </v-list-item>
            </v-list>
            <div class="pt-4 pb-4 px-5 text-center">
                <v-btn color="primary" variant="outlined" block @click="handleLogout">Salir</v-btn>
            </div>
        </v-sheet>
    </v-menu>
</template>
