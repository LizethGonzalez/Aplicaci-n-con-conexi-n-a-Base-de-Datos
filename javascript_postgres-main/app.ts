import { Hono } from 'hono';
import actorRouter from './src/routes/actor.route';
import FilmRouter from './src/routes/film.route';  // Importa FilmRouter
import { errorHandler } from './src/middlewares/error_handler.ts';

const app = new Hono();

app.use('*', errorHandler); // Middleware global

// Monta actorRouter en /
app.route('/', actorRouter);

// Monta FilmRouter en /api o en otra ruta que quieras
app.route('/api', FilmRouter);

export default app;
