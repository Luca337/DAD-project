import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        // Verifica se já existe um token guardado no browser
        token: localStorage.getItem('token') || null, 
    }),
    actions: {
        setToken(novoToken) {
            this.token = novoToken;
            localStorage.setItem('token', novoToken); // Guarda no browser
            // Ensina o Axios a enviar sempre este token no cabeçalho das próximas chamadas
            axios.defaults.headers.common['Authorization'] = `Bearer ${novoToken}`;
        },
        logout() {
            this.token = null;
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        }
    }
});