    import type {MiddlewareHandler} from 'hono';
    import { ZodError } from 'zod';
    import { HttpResponse } from '../utils/http_reponse.ts';

    export const errorHandler: MiddlewareHandler = async (c, next) => {
        try {
            await next();
        } catch (err: any) {
            console.error('🔴 Error atrapado por middleware:', err);


            if (err instanceof ZodError) {
                const message = err.errors.map(e => e.message).join(', ');
                const res = HttpResponse.badRequest(`Datos inválidos: ${message}`);
                return new Response(JSON.stringify(res.body), {
                    status: res.status,
                    headers: { 'Content-Type': 'application/json' }
                });
            }

            // Otro tipo de error (por ejemplo de base de datos, lógica, etc.)
            const status = err.status || 500;
            const message = err.message || 'Error interno del servidor';
            const res = HttpResponse.error(message, status);
            return new Response(JSON.stringify(res.body), {
                status: status,
                headers: { 'Content-Type': 'application/json' }
            });
        }
    };
