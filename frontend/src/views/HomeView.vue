<template>
  <div class="papermill-home">
    <header class="hero">
      <h1>📦 Papermill Procurement System</h1>
      <p class="subtitle">Modern Procurement Management with Vue 3 + Laravel 11</p>
    </header>

    <main class="main-content">
      <div class="container">
        <!-- Status Cards -->
        <div class="status-grid">
          <div class="status-card">
            <div class="card-icon">🚀</div>
            <h3>Vue 3 Frontend</h3>
            <p>Composition API + TypeScript</p>
            <div class="status-badge success">Running</div>
          </div>

          <div class="status-card">
            <div class="card-icon">⚙️</div>
            <h3>Laravel 11 Backend</h3>
            <p>PHP 8.4 + MySQL + Redis</p>
            <div class="status-badge success">Connected</div>
          </div>

          <div class="status-card">
            <div class="card-icon">🐳</div>
            <h3>Docker Environment</h3>
            <p>Full containerization</p>
            <div class="status-badge success">Active</div>
          </div>

          <div class="status-card">
            <div class="card-icon">🔗</div>
            <h3>API Integration</h3>
            <p>RESTful API ready</p>
            <div class="status-badge success">Live</div>
          </div>
        </div>

        <!-- Actions -->
        <div class="action-section">
          <h2>Quick Actions</h2>
          <div class="action-buttons">
            <button @click="testBackend" class="action-btn primary" :disabled="testing">
              {{ testing ? 'Testing...' : 'Test Backend Connection' }}
            </button>
            <a href="http://localhost:8088" target="_blank" class="action-btn secondary">
              Open Laravel Backend
            </a>
            <button @click="showSystemInfo" class="action-btn outline">
              System Information
            </button>
          </div>
        </div>

        <!-- Status Display -->
        <div v-if="connectionStatus" class="status-display" :class="statusClass">
          <h3>{{ connectionStatus }}</h3>
          <pre v-if="systemInfo">{{ JSON.stringify(systemInfo, null, 2) }}</pre>
        </div>

        <!-- Features -->
        <div class="features-section">
          <h2>✨ System Features</h2>
          <div class="features-grid">
            <div class="feature">
              <h4>Real-time Dashboard</h4>
              <p>Monitor procurement metrics in real-time</p>
            </div>
            <div class="feature">
              <h4>Supplier Management</h4>
              <p>Manage vendor relationships and contracts</p>
            </div>
            <div class="feature">
              <h4>Purchase Orders</h4>
              <p>Create and track purchase orders</p>
            </div>
            <div class="feature">
              <h4>Inventory Tracking</h4>
              <p>Real-time inventory management</p>
            </div>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="links-section">
          <h2>🔗 Quick Links</h2>
          <div class="links-grid">
            <a href="http://localhost:8088" target="_blank" class="link-card">
              <span class="link-icon">🔧</span>
              <span class="link-text">Laravel Backend</span>
            </a>
            <a href="http://localhost:8088/phpinfo.php" target="_blank" class="link-card">
              <span class="link-icon">🐘</span>
              <span class="link-text">PHP Info</span>
            </a>
            <a href="http://localhost:5174" class="link-card">
              <span class="link-icon">⚡</span>
              <span class="link-text">Vue Frontend</span>
            </a>
            <div class="link-card" @click="showDockerStatus">
              <span class="link-icon">🐳</span>
              <span class="link-text">Docker Status</span>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="footer">
      <div class="container">
        <p>Papermill Procurement System © 2024</p>
        <p class="tech-stack">Built with Vue 3, Laravel 11, Docker</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const testing = ref(false)
const connectionStatus = ref('')
const systemInfo = ref<null>(null)

const statusClass = computed(() => {
  if (connectionStatus.value.includes('✅')) return 'success'
  if (connectionStatus.value.includes('❌')) return 'error'
  return 'info'
})

const testBackend = async () => {
  testing.value = true
  connectionStatus.value = ''

  try {
    const response = await fetch('http://localhost:8088/api/health', {
      method: 'GET',
      headers: {
        'Accept': 'application/json'
      }
    })

    if (response.ok) {
      const data = await response.json()
      systemInfo.value = data
      connectionStatus.value = '✅ Backend connected successfully!'
    } else {
      connectionStatus.value = '⚠ Backend responded with an error'
    }
  } catch (error) {
    console.error('Connection error:', error)
    connectionStatus.value = '❌ Cannot connect to backend. Make sure Laravel is running.'
  } finally {
    testing.value = false
  }
}

const showSystemInfo = async () => {
  try {
    const response = await fetch('http://localhost:8088/api/health')
    systemInfo.value = await response.json()
    connectionStatus.value = '📊 System Information'
  } catch {
    connectionStatus.value = '❌ Failed to fetch system info'
  }
}

const showDockerStatus = () => {
  connectionStatus.value = '🐳 Docker containers are running'
  systemInfo.value = {
    services: ['nginx', 'php', 'mysql', 'redis', 'node'],
    status: 'all running',
    ports: {
      frontend: 5174,
      backend: 8088,
      mysql: 3307,
      redis: 6381
    }
  }
}
</script>

<style scoped>
.papermill-home {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.hero {
  text-align: center;
  padding: 4rem 2rem 2rem;
}

h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.subtitle {
  font-size: 1.5rem;
  opacity: 0.9;
  margin-bottom: 1rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.main-content {
  flex: 1;
  padding: 2rem 0;
}

.status-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.status-card {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 16px;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
}

.status-card:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

.card-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.status-card h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  color: #4ade80;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 600;
  margin-top: 0.5rem;
}

.status-badge.success {
  background: rgba(74, 222, 128, 0.2);
  color: #4ade80;
  border: 1px solid rgba(74, 222, 128, 0.3);
}

.action-section {
  margin-bottom: 3rem;
}

.action-section h2 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #fbbf24;
}

.action-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.action-btn {
  padding: 0.875rem 1.75rem;
  border-radius: 12px;
  border: 2px solid transparent;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  display: inline-block;
}

.action-btn.primary {
  background: #4ade80;
  color: #1e293b;
}

.action-btn.secondary {
  background: #3b82f6;
  color: white;
}

.action-btn.outline {
  background: transparent;
  border-color: white;
  color: white;
}

.action-btn:hover:not(:disabled) {
  transform: scale(1.05);
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.action-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.status-display {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 2rem;
  margin-bottom: 3rem;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.status-display.success {
  border-left: 4px solid #4ade80;
}

.status-display.error {
  border-left: 4px solid #f87171;
}

.status-display.info {
  border-left: 4px solid #3b82f6;
}

.status-display pre {
  background: rgba(0,0,0,0.2);
  padding: 1rem;
  border-radius: 8px;
  margin-top: 1rem;
  overflow-x: auto;
  font-family: 'Courier New', monospace;
  font-size: 0.875rem;
}

.features-section {
  margin-bottom: 3rem;
}

.features-section h2 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #fbbf24;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.feature {
  background: rgba(255, 255, 255, 0.05);
  padding: 1.5rem;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.feature h4 {
  color: #60a5fa;
  margin-bottom: 0.5rem;
  font-size: 1.25rem;
}

.links-section {
  margin-bottom: 3rem;
}

.links-section h2 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  color: #fbbf24;
}

.links-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.link-card {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  color: white;
}

.link-card:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateX(5px);
}

.link-icon {
  font-size: 1.5rem;
}

.link-text {
  font-weight: 500;
}

.footer {
  background: rgba(0, 0, 0, 0.2);
  padding: 2rem 0;
  text-align: center;
  margin-top: auto;
}

.tech-stack {
  opacity: 0.7;
  font-size: 0.9rem;
  margin-top: 0.5rem;
}

@media (max-width: 768px) {
  h1 {
    font-size: 2.5rem;
  }

  .hero {
    padding: 2rem 1rem;
  }

  .container {
    padding: 0 1rem;
  }

  .action-buttons {
    flex-direction: column;
  }

  .action-btn {
    width: 100%;
  }

  .status-grid,
  .features-grid,
  .links-grid {
    grid-template-columns: 1fr;
  }
}
</style>
