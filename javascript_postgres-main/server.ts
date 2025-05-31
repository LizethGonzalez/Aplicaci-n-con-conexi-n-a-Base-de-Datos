import { config } from 'dotenv';
config();
import { serve } from 'bun';
import app from './app';

const PORT = process.env.PORT || 3000;

console.log(`🚀 Servidor escuchando en http://localhost:${PORT}`);

serve({
    fetch: app.fetch,
    port: PORT,
});
