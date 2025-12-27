<template>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-brand">
        <router-link to="/" class="brand">
          <span class="brand-icon">📦</span>
          <span class="brand-text">Papermill Procurement</span>
        </router-link>
      </div>

      <div class="nav-menu">
        <router-link to="/" class="nav-link">Home</router-link>
        <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
        <router-link to="/about" class="nav-link">About</router-link>
      </div>

      <div class="nav-status">
        <div class="status-indicator" :class="backendStatus">
          {{ statusText }}
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

const backendStatus = ref<'online' | 'offline' | 'checking'>('checking')

const statusText = computed(() => {
  switch (backendStatus.value) {
    case 'online': return 'Backend Online'
    case 'offline': return 'Backend Offline'
    default: return 'Checking...'
  }
})

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8088/api/health', {
      signal: AbortSignal.timeout(3000)
    })
    backendStatus.value = response.ok ? 'online' : 'offline'
  } catch {
    backendStatus.value = 'offline'
  }
})
</script>

<style scoped>
.navbar {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.nav-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 64px;
}

.brand {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
  color: #2c3e50;
  font-weight: 700;
  font-size: 1.25rem;
}

.brand-icon {
  font-size: 1.5rem;
}

.nav-menu {
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: #64748b;
  text-decoration: none;
  padding: 0.5rem 0;
  position: relative;
  transition: color 0.2s;
}

.nav-link:hover,
.nav-link.router-link-active {
  color: #3b82f6;
}

.nav-link.router-link-active::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: #3b82f6;
  border-radius: 2px;
}

.status-indicator {
  padding: 0.375rem 0.875rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 500;
}

.status-indicator.online {
  background: #d1fae5;
  color: #065f46;
}

.status-indicator.offline {
  background: #fee2e2;
  color: #991b1b;
}

.status-indicator.checking {
  background: #fef3c7;
  color: #92400e;
}

@media (max-width: 768px) {
  .nav-container {
    padding: 0 1rem;
  }

  .brand-text {
    display: none;
  }

  .nav-menu {
    gap: 1rem;
  }
}
</style>
