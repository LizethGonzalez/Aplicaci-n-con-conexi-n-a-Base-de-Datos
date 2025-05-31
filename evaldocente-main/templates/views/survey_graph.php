<div class="card shadow w-50" >
        <label for="teacher">Docente:</label>
        <select id="teacher" name="teacher">
            <?php
            foreach ($teachers as $teacher){
                echo ("<option value='" . $teacher['docente'] . "'>" . $teacher['docente'] ."</optio>" );
            }
            ?>
        </select>
        &nbsp;
        <button class="btn btn-primary" id="btnGenerateGraph">Ver gráfica</button>
</div>

<!-- Ícono de carga oculto por defecto -->
<i id="loadingSpinner" class="bi bi-arrow-repeat spinner-border" style="display: none; font-size: 1.5rem; color: #0d6efd;" title="Cargando..."></i>


<!-- Incluir ECharts y echarts-gl -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts-gl@2/dist/echarts-gl.min.js"></script>

<!-- Contenedor del gráfico -->
<div id="graph3d" style="width: 800px; height: 600px;"></div>

<script>

     const generateGraph = (data) => {
        const questions = [...new Set(data.map(d => d.pregunta))];
         const labelValues = ["Nunca", "A veces", "Frecuentemente", "Siempre"];

        //-- Formato para ECharts: [x=valor (índice), y=pregunta (índice), z=frecuencia]
        const seriesData = data.map(d => {
            return [
                d.valor - 1, // x (0 a 3)
                questions.indexOf(d.pregunta), // y (0 a 2)
                d.frecuencia // z
            ];
        });

        //--- Configurar gráfico
        const chart = echarts.init(document.getElementById('graph3d'));

        const option = {
            tooltip: {
                formatter: function (params) {
                    const x = params.value[0]; // índice del valor
                    const y = params.value[1]; // índice de la pregunta
                    const z = params.value[2]; // frecuencia

                    return `
                        <b>Pregunta:</b> ${questions[y]}<br/>
                        <b>Respuesta:</b> ${labelValues[x]}<br/>
                        <b>Frecuencia:</b> ${z}
                        `;
                }
            }
            ,
            visualMap: {
                max: Math.max(...data.map(d => d.frecuencia)),
                inRange: { color: ['#d94e5d','#eac736','#50a3ba'] }
            },
            xAxis3D: {
                type: 'category',
                name: 'Valor',
                data: labelValues
            },
            yAxis3D: {
                type: 'category',
                name: 'Preguntas',
                data: questions
            },
            zAxis3D: {
                type: 'value',
                name: 'Frecuencia',
                min: 0
            },
            grid3D: {
                boxWidth: 100,
                boxDepth: 100,
                viewControl: {
                    //--- rotation para mejor perspectiva
                    //autoRotate: true
                },
                light: {
                    main: {
                        intensity: 1.2,
                        shadow: true
                    },
                    ambient: {
                        intensity: 0.3
                    }
                }
            },
            series: [{
                type: 'bar3D',
                data: seriesData,
                shading: 'lambert',
                label: {
                    show: true,
                    formatter: function (params) {
                        const x = params.value[0];
                        const y = params.value[1];
                        const z = params.value[2];

                        return `${labelValues[x]}: ${z}`;
                    },
                    fontSize: 12,
                    color: '#000'
                },

                emphasis: {
                    label: {
                        show: true,
                        formatter: function (param) {
                            return `Frecuencia: ${param.value[2]}`;
                        }
                    }
                }
            }]

        };

        chart.setOption(option);
    }

    document.getElementById("btnGenerateGraph").addEventListener("click", () => {
        const spinner = document.getElementById("loadingSpinner");

        spinner.style.display = "inline-block"; // Mostrar progressbar al inciar


        const teacher = document.getElementById("teacher").value;
        fetch("/survey/statistics", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ "teacher":teacher })
        }).then(responseHttp => {
                if (!responseHttp.ok) {
                    throw new Error("Error al obtener los datos");
                }
                return responseHttp.json();
            })
            .then(response => {
                console.log("Datos recibidos:", response);
                generateGraph(response.data);
            })
            .catch(error => {
                console.error("Error en fetch:", error);
            })
            .finally(() => {

                spinner.style.display = "none";
        });
    });

     document.getElementById("teacher").addEventListener("change", () => {
         document.getElementById("btnGenerateGraph").click();
     });

     window.addEventListener("DOMContentLoaded", () => {
         document.getElementById("btnGenerateGraph").click();
     });

</script>
