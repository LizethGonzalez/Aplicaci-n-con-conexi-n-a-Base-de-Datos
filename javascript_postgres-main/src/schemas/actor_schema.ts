import { pgTable, serial, varchar } from 'drizzle-orm/pg-core';
import { z } from 'zod';

// Definición de la tabla con Drizzle
export const actor = pgTable('actor', {
    actor_id: serial('actor_id').primaryKey(),
    first_name: varchar('first_name', { length: 45 }),
    last_name: varchar('last_name', { length: 45 }),
});

// Aquí agregamos el schema para validaciones
export const actorSchema = z.object({
    first_name: z.string().min(1, 'El nombre es obligatorio'),
    last_name: z.string().min(1, 'El apellido es obligatorio'),
});
