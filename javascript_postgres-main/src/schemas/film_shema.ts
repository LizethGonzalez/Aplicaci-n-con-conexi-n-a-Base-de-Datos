import { z } from 'zod';

export const filmSchema = z.object({
    title: z.string().min(10, "El título es obligatorio con una longitud mínima de 10"),
    description: z.string().min(10, "La descripción es obligatoria y mínima de 10"),
    release_year: z.coerce.number()
        .int("El año debe ser un número entero")
        .gte(1900, "El año debe ser mayor o igual a 1900")
        .lte(new Date().getFullYear(), "El año no puede ser mayor al actual"),
    language_id: z.number({ required_error: "El idioma es obligatorio" }).int()
});
