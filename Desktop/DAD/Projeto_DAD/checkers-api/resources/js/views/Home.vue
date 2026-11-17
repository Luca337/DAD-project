<template>
  <div class="login-container">
    <div class="login-card">
      <div class="header">
        <h2>Área de Acesso</h2>
        <p>Teste R1: Integração com Backend</p>
      </div>

      <!-- ZONA 1: Formulário de Login -->
      <div v-if="!authStore.token" class="form-section">
        <div class="input-group">
          <label for="email">Email</label>
          <input id="email" v-model="email" type="email" placeholder="exemplo@email.com" />
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input id="password" v-model="password" type="password" placeholder="••••••••" />
        </div>
        
        <button class="btn btn-primary" @click="fazerLogin">Entrar no Sistema</button>
        
        <div v-if="mensagemErro" class="alert alert-error">
          {{ mensagemErro }}
        </div>
      </div>

      <!-- ZONA 2: Área Autenticada -->
      <div v-else class="form-section">
        <div class="alert alert-success">
          <strong>✅ Autenticado com sucesso!</strong>
          <br>O Token está guardado e ativo no Axios.
        </div>
        
        <div class="button-group">
          <button class="btn btn-secondary" @click="testarRotaProtegida">Testar Endpoint</button>
          <button class="btn btn-danger" @click="authStore.logout()">Sair</button>
        </div>

        <!-- Mostra a resposta do servidor -->
        <div v-if="respostaServidor" class="response-box">
          <span>Resposta do Membro 1:</span>
          <pre>{{ respostaServidor }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useAuthStore } from '../stores/auth'; // Confirma se o caminho está certo

const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const mensagemErro = ref('');
const respostaServidor = ref(null);

if (authStore.token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${authStore.token}`;
}

const fazerLogin = async () => {
    mensagemErro.value = '';
    try {
        const resposta = await axios.post('http://127.0.0.1:8000/api/login', {
            email: email.value,
            password: password.value
        });
        const tokenRecebido = resposta.data.token; 
        authStore.setToken(tokenRecebido);
    } catch (error) {
        mensagemErro.value = 'Email ou password incorretos. Tenta novamente.';
        console.error(error);
    }
};

const testarRotaProtegida = async () => {
    try {
        const resposta = await axios.get('http://127.0.0.1:8000/api/user');
        respostaServidor.value = resposta.data; 
    } catch (error) {
        respostaServidor.value = 'Erro! O servidor rejeitou o pedido (Token inválido).';
        console.error(error);
    }
};
</script>

<style scoped>
/* Fundo de ecrã a ocupar a altura toda e centrar o cartão */
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f3f4f6; /* Cinza muito claro */
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* O cartão branco central */
.login-card {
  background: white;
  width: 100%;
  max-width: 400px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  padding: 30px;
}

/* Títulos */
.header {
  text-align: center;
  margin-bottom: 25px;
}
.header h2 {
  margin: 0 0 5px 0;
  color: #1f2937;
  font-size: 24px;
}
.header p {
  margin: 0;
  color: #6b7280;
  font-size: 14px;
}

/* Secções do formulário */
.form-section {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
}
.input-group label {
  font-size: 13px;
  font-weight: 600;
  color: #374151;
}
.input-group input {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s;
}
.input-group input:focus {
  border-color: #3b82f6; /* Azul ao clicar */
}

/* Estilo Base dos Botões */
.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.1s;
}
.btn:active {
  transform: scale(0.98);
}
.btn-primary {
  background-color: #3b82f6;
  color: white;
  width: 100%;
  margin-top: 10px;
}
.btn-primary:hover { background-color: #2563eb; }

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}
.btn-secondary {
  background-color: #f3f4f6;
  color: #374151;
  flex: 1;
}
.btn-secondary:hover { background-color: #e5e7eb; }

.btn-danger {
  background-color: #fee2e2;
  color: #dc2626;
}
.btn-danger:hover { background-color: #fecaca; }

/* Avisos (Sucesso e Erro) */
.alert {
  padding: 12px;
  border-radius: 6px;
  font-size: 13px;
  text-align: center;
}
.alert-error {
  background-color: #fef2f2;
  color: #b91c1c;
  border: 1px solid #fecaca;
}
.alert-success {
  background-color: #f0fdf4;
  color: #15803d;
  border: 1px solid #bbf7d0;
}

/* Caixa de resposta do servidor */
.response-box {
  background-color: #1f2937;
  color: #10b981;
  padding: 15px;
  border-radius: 6px;
  margin-top: 15px;
  font-size: 12px;
  overflow-x: auto;
}
.response-box span {
  color: #9ca3af;
  display: block;
  margin-bottom: 8px;
}
.response-box pre {
  margin: 0;
}
</style>