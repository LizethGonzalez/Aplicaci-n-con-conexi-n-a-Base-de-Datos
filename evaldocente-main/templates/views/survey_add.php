    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-4 text-center">Encuesta de Evaluación Docente</h1>

                <form method="POST" action="/survey/save" id="surveyForm" class="card p-4 shadow bg-white rounded-3">
                    <div class="mb-3">
                        <label for="docente" class="form-label">Nombre del docente:</label>
                        <input type="text" class="form-control" id="docente" name="docente" required>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta1" class="form-label">1. ¿Explica claramente los temas?</label>
                        <select class="form-select" name="pregunta1" id="pregunta1" required>
                            <option value="">Seleccione</option>
                            <option value="1">Nunca</option>
                            <option value="2">A veces</option>
                            <option value="3">Frecuentemente</option>
                            <option value="4">Siempre</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta2" class="form-label">2. ¿Fomenta la participación?</label>
                        <select class="form-select" name="pregunta2" id="pregunta2" required>
                            <option value="">Seleccione</option>
                            <option value="1">Nunca</option>
                            <option value="2">A veces</option>
                            <option value="3">Frecuentemente</option>
                            <option value="4">Siempre</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pregunta3" class="form-label">3. ¿Es puntual y responsable?</label>
                        <select class="form-select" name="pregunta3" id="pregunta3" required>
                            <option value="">Seleccione</option>
                            <option value="1">Nunca</option>
                            <option value="2">A veces</option>
                            <option value="3">Frecuentemente</option>
                            <option value="4">Siempre</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comentarios" class="form-label">Comentarios adicionales:</label>
                        <textarea class="form-control" name="comentarios" id="comentarios" rows="4"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" id="sendSurveyButton" class="btn btn-primary">Enviar evaluación</button>
                    </div>
                </form>
                <div id="responseMessage"></div>
            </div>
        </div>
    </div>


