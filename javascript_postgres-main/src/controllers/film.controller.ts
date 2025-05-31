import { filmService } from '../services/film.service';
import { HttpResponse } from '../utils/http_reponse.ts';

export const filmController = {
    getAll: async () => {
        try {
            const films = await filmService.getAll();
            return HttpResponse.ok(films, "Películas recuperadas correctamente");
        } catch (error) {
            return HttpResponse.error("Error al recuperar las películas");
        }
    },

    getById: async (id: number) => {
        try {
            const film = await filmService.getById(id);
            if (!film) return HttpResponse.notFound("Película no encontrada");
            return HttpResponse.ok([film], "Película encontrada");
        } catch (error) {
            return HttpResponse.error("Error al recuperar la película");
        }
    },

    add: async (body: {
        title: string;
        description: string;
        release_year: number;
        language_id: number;
    }) => {
        try {

            const newFilm = await filmService.add(
                body.title,
                body.description,
                body.release_year,
                body.language_id
            );

            return HttpResponse.created(newFilm, "Película creada");
        } catch (error) {
            console.error("Error al crear película:", error); // 👈 Añade logs
            return HttpResponse.error("Error al crear la película");
        }
    },


    update: async (id: number, body: { title: string; description: string; release_year: number }) => {
        try {
            const releaseYearNumber = Number(body.release_year);
            if (body.release_year !== undefined && isNaN(releaseYearNumber)) {
                return HttpResponse.error("El año de lanzamiento debe ser un número válido", 400);
            }

            const updatedFilm = await filmService.update(id, body.title, body.description, releaseYearNumber);
            if (!updatedFilm) return HttpResponse.notFound("Película no encontrada para actualizar");

            return HttpResponse.ok(updatedFilm, "Película actualizada");
        } catch (error) {
            return HttpResponse.error("Error al actualizar la película");
        }
    },

    delete: async (id: number) => {
        try {
            const deleted = await filmService.delete(id);
            if (!deleted) return HttpResponse.notFound("Película no encontrada para eliminar");
            return HttpResponse.ok(null, "Película eliminada correctamente");
        } catch (error) {
            return HttpResponse.error("Error al eliminar la película");
        }
    },
};
