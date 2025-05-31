import { Hono } from 'hono';
import type { Context } from 'hono';
import { filmController } from '../controllers/film.controller';
import { filmSchema } from '../schemas/film_shema.ts';
import { validateBody } from '../middlewares/validate';
import type { z } from 'zod';
type FilmInput = z.infer<typeof filmSchema>;

const FilmRouter = new Hono();

FilmRouter.get('/films', async () => {
    const { status, body } = await filmController.getAll();
    return new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });
});

FilmRouter.get('/films/:id', async (c: Context) => {
    const id = Number(c.req.param('id'));
    const { status, body } = await filmController.getById(id);
    return new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });
});

FilmRouter.post('/films', validateBody(filmSchema), async (c: Context & { get(key: 'validatedBody'): FilmInput }) => {
    const bodyValidated = c.get('validatedBody');
    const { status, body } = await filmController.add(bodyValidated);
    return new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });
});

FilmRouter.put('/films/:id', validateBody(filmSchema), async (c: Context & { get(key: 'validatedBody'): FilmInput }) => {
    const id = Number(c.req.param('id'));
    const bodyValidated = c.get('validatedBody'); // ✅ release_year ya es number
    const { status, body } = await filmController.update(id, bodyValidated);
    return new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });
});


FilmRouter.delete('/films/:id', async (c: Context) => {
    const id = Number(c.req.param('id'));
    const { status, body } = await filmController.delete(id);
    return new Response(JSON.stringify(body), { status, headers: { 'Content-Type': 'application/json' } });
});

export default FilmRouter;
