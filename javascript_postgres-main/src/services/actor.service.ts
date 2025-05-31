import { ActorRepository } from '../repositories/actor.repos.ts';

export const ActorService = {
    getAll: () => ActorRepository.findAll(),
    getById: (id: number) => ActorRepository.findById(id),
    add: (first_name: string, last_name: string) =>
        ActorRepository.add({ first_name, last_name }),
};
