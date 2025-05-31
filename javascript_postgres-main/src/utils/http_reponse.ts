
import { HTTP_STATUS } from './http_status.ts';

export class HttpResponse {
    static ok(data: any, message = "Operación exitosa") {
        return {
            status: HTTP_STATUS.OK,
            body: {
                success: true,
                message,
                data,
            },
        };
    }

    static created(data: any, message = "Recurso creado") {
        return {
            status: HTTP_STATUS.CREATED,
            body: {
                success: true,
                message,
                data,  // Datos creados
            },
        };
    }

    static error(message = "Error interno del servidor", status = 500) {
        return {
            status,
            body: {
                success: false,
                message,
                data: [],
            },
        };
    }

    static badRequest(message = "Solicitud incorrecta") {
        return {
            status: HTTP_STATUS.BAD_REQUEST,
            body: {
                success: false,
                message,
                data: [],
            },
        };
    }

    static notFound(message = "Recurso no encontrado") {
        return {
            status: HTTP_STATUS.NOT_FOUND,
            body: {
                success: false,
                message,
                data: [],
            },
        };
    }
}
