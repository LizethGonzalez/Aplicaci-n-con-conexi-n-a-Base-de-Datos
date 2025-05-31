// src/utils/api-error.ts
import { HTTP_STATUS } from './http_status.ts';

export class ApiError extends Error {
    public status: number;
    public data: any;
    public success: boolean;

    constructor(status: number, message: string, data: any = []) {
        super(message);
        this.name = 'ApiError';
        this.status = status;
        this.data = data;
        this.success = false;
    }

    static badRequest(message = "Bad Request", data: any = []) {
        return new ApiError(HTTP_STATUS.BAD_REQUEST, message, data);
    }

    static notFound(message = "Not Found", data: any = []) {
        return new ApiError(HTTP_STATUS.NOT_FOUND, message, data);
    }

    static internal(message = "Internal Server Error", data: any = []) {
        return new ApiError(HTTP_STATUS.INTERNAL_SERVER_ERROR, message, data);
    }

    static unauthorized(message = "Unauthorized", data: any = []) {
        return new ApiError(HTTP_STATUS.UNAUTHORIZED, message, data);
    }


}
