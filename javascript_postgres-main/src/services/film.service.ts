import { filmsRepos } from '../repositories/films.repos.ts';

export const filmService = {
    getAll: () => filmsRepos.findAll(),

    getById: (id: number) => filmsRepos.findById(id),

    add: (title: string, description: string, release_year: number, language_id: number) =>
        filmsRepos.add({ title, description, release_year, language_id }),


    update: (id: number, title: string, description: string, release_year: number) =>
        filmsRepos.update(id, { title, description, release_year}),

    delete: (id: number) => filmsRepos.delete(id),
};
