import { Hono } from 'hono';
import { ActorController } from '../controllers/actor.controller.ts';
import { validateBody } from '../middlewares/validate.ts';
import { actorSchema } from '../schemas/actor_schema.ts';

import type { Context } from 'hono';
import type { z } from 'zod';

type ActorInput = z.infer<typeof actorSchema>;

const actorRouter = new Hono();

actorRouter.get('/actors', async (): Promise<Response> => {
    const { status, body } = await ActorController.getAll();
    return new Response(JSON.stringify(body), {
        status,
        headers: { 'Content-Type': 'application/json' }
    });
});

actorRouter.get('/actors/:id', async (c) => {
    const id = Number(c.req.param('id'));
    const { status, body } = await ActorController.getById(id);
    return new Response(JSON.stringify(body), {
        status,
        headers: { 'Content-Type': 'application/json' }
    });
});

actorRouter.post(
    '/actors',
    validateBody(actorSchema),
    async (c: Context & { get(key: 'validatedBody'): ActorInput }) => {
        const bodyValidated = c.get('validatedBody');
        const { status, body } = await ActorController.add(bodyValidated);
        return new Response(JSON.stringify(body), {
            status,
            headers: { 'Content-Type': 'application/json' }
        });
    }
);

actorRouter.put(
    '/actors/:id',
    validateBody(actorSchema),
    async (c: Context & { get(key: 'validatedBody'): ActorInput }) => {
        const id = Number(c.req.param('id'));
        const body = c.get('validatedBody');
        const { status, body: result } = await ActorController.update(id, body);
        return new Response(JSON.stringify(result), {
            status,
            headers: { 'Content-Type': 'application/json' }
        });
    }
);

actorRouter.delete('/actors/:id', async (c) => {
    const id = Number(c.req.param('id'));
    const { status, body } = await ActorController.delete(id);
    return new Response(JSON.stringify(body), {
        status,
        headers: { 'Content-Type': 'application/json' }
    });
});

export default actorRouter;
