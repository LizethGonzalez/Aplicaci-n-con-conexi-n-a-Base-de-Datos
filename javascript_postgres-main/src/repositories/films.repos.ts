import { db } from '../db/index.ts';
import { films } from '../db/schema.ts';
import { eq } from 'drizzle-orm/sql/expressions/conditions';

export const filmsRepos = {
    findAll: async () => db.select().from(films),

    findById: async (id: number) => {
        const [film] = await db.select().from(films).where(eq(films.film_id, id));
        return film;
    },

    add: async (data: { title: string; description: string; release_year?: number; language_id: number }) =>
        db.insert(films).values(data).returning(),

    update: async (
        id: number,
        data: { title?: string; description?: string; release_year?: number }
    ) => {
        const result = await db
            .update(films)
            .set(data)
            .where(eq(films.film_id, id))
            .returning();
        return result.length ? result[0] : null;
    },

    delete: async (id: number) => {
        const result = await db.delete(films).where(eq(films.film_id, id));
        return result?.rowCount != null && result.rowCount > 0;

    },
};
