@extends('layouts.public')

@section('title', 'Visa')

@section('content')

    <div class="info-visa-container">
        <div class="return-page">
            <div class="small-title-page">
                <a class="inicio-link" href="/">
                    <span>Inicio</span>
                </a>
                <span> > </span>
                <b class="name-page">Vigencia del visado, visas y visas electrónicas de Estados Unidos</b>
            </div>
        </div>
        <div class="title-page">
            Vigencia del visado, visas y visas electrónicas de Estados Unidos
        </div>
        <div class="text-page">
            <div class="info-text">
                <span class="small-info">
                    <span class="info-name">
                        iVisa
                    </span>
                    <div class="separator"></div>
                    9 min leer
                    <div class="separator"></div>
                    Actualizado el Sep 09, 2024
                </span>
            </div>
        </div>
    </div>

    <div class="info-container">
        <div class="division">
            <div class="info-col-table">
                <div class="info-table-form">
                    <div style="padding: 32px">
                        <form action="">
                            <p class="form-title">Solicitar ahora</p>
                            <h4 class="label-form">¿De dónde eres?</h4>
                            <div class="custom-select" id="from-select">
                                <div class="selected-option">
                                    <img src="flags/peru.png" alt="Perú"> Perú
                                </div>
                                <div class="dropdown-form">
                                    <input type="text" class="search-input" placeholder="Buscar país...">
                                    <div class="options-list">
                                        <div class="option" data-value="peru"><img src="flags/peru.png" alt="Perú"> Perú
                                        </div>
                                        <div class="option" data-value="alemania"><img src="flags/germany.png"
                                                alt="Alemania"> Alemania</div>
                                        <div class="option" data-value="australia"><img src="flags/australia.png"
                                                alt="Australia"> Australia</div>
                                        <div class="option" data-value="canada"><img src="flags/canada.png" alt="Canadá">
                                            Canadá</div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="label-form">Where are you going?</h4>
                            <div class="custom-select" id="to-select">
                                <div class="selected-option">
                                    <img src="flags/canada.png" alt="EEUU"> Estados Unidos
                                </div>
                                <div class="dropdown-form">
                                    <input type="text" class="search-input" placeholder="Buscar país...">
                                    <div class="options-list">
                                        <div class="option" data-value="peru"><img src="flags/peru.png" alt="Perú"> Perú
                                        </div>
                                        <div class="option" data-value="alemania"><img src="flags/germany.png"
                                                alt="Alemania"> Alemania</div>
                                        <div class="option" data-value="australia"><img src="flags/australia.png"
                                                alt="Australia"> Australia</div>
                                        <div class="option" data-value="canada"><img src="flags/canada.png" alt="Canadá">
                                            Canadá</div>
                                    </div>
                                </div>
                            </div>

                            <button class="apply-btn">¡Aplica ahora! <span>→</span></button>
                        </form>
                    </div>
                </div>

                <div class="info-table">
                    <div style="padding: 32px">
                        <p class="info-title">Ir a:</p>
                        <ul style="list-style: none; padding-left: 0%; margin-bottom: 0%;">
                            <li>
                                <a href="#diferents-types-visas" class="info-item">
                                    <span class="info-number">01</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Diferentes tipos de visas de Estados Unidos y su
                                        vigencia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#factors-that-afect-visas" class="info-item">
                                    <span class="info-number">02</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Factores que afectan la vigencia de una visa de Estados
                                        Unidos</span>
                                </a>
                            </li>
                            <li>
                                <a href="#electronic-visas-vwp-esta" class="info-item">
                                    <span class="info-number">03</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Visas electrónicas: Visa Waiver Program (VWP) y
                                        Electronic System for Travel Authorization (ESTA)</span>
                                </a>
                            </li>
                            <li>
                                <a href="#requiers-to-get-visa-canada" class="info-item">
                                    <span class="info-number">04</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Diferencia entre la vigencia de la visa y duración de la
                                        estancia permitida</span>
                                </a>
                            </li>
                            <li>
                                <a href="#how-renovate-extend-visa" class="info-item">
                                    <span class="info-number">05</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Como renovar o extender la vigencia de la visa para
                                        ingresar a Estados Unidos</span>
                                </a>
                            </li>
                            <li>
                                <a href="#consecuence-of-stay-more" class="info-item">
                                    <span class="info-number">06</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">Consecuencias de quedarse más allá de la vigencia de una
                                        visa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#how-afect-my-nationality" class="info-item">
                                    <span class="info-number">07</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Cómo afecta mi nacionalidad a la vigencia de mi visa de
                                        Estados Unidos?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#need-a-visa-if-visit-usa" class="info-item">
                                    <span class="info-number">08</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Necesito una visa si visito Estados Unidos por un corto
                                        periodo de tiempo?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#how-many-time-visa" class="info-item">
                                    <span class="info-number">09</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Cuanto tiempo de vigencia debe tener mi pasaporte para
                                        solicitar una visa de Estados Unidos?</span>
                                </a>
                            </li>
                            <li>
                                <a href="#can-i-travel-USA-if" class="info-item">
                                    <span class="info-number">10</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Puedo viajar a Estados Unidos si mi visa está a punto de
                                        caducar?</span>
                                </a>
                            </li>
                            <li>
                                <a href="#how-long-it-takes" class="info-item">
                                    <span class="info-number">11</span>
                                    <div class="separator"></div>
                                    <span class="info-text-option">¿Cuánto tiempo tarda en procesarse una solicitud de visa
                                        de Estados Unidos?</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="info-col-article">
                <p class="many-text">Si estás planeando un viaje a los Estados Unidos, es
                    fundamental entender la vigencia de los documentos necesarios. Nosotros exploraremos dos de las opciones
                    más comunes: la Visa B1/B2 y el sistema ESTA.
                </p>
                <p class="all-text">Comprender la duración de validez de estos documentos es crucial para planificar tu
                    viaje de manera adecuada y evitar cualquier contratiempo en tu llegada a suelo estadounidense.
                </p>
                <p class="all-text"><img data-zoom-image=""
                        data-src="https://d2kzh91pcly9gn.cloudfront.net/mile-bridge-us-landscape.webp"
                        alt="Milebridge USA Landscape" data-ll-status="loaded" class="image entered loaded"
                        src="https://d2kzh91pcly9gn.cloudfront.net/mile-bridge-us-landscape.webp">
                </p>

                <h2 id="diferents-types-visas" class="subtitle">Diferentes tipos de visas de Estados Unidos y su vigencia
                </h2>

                <h3 class="subtitle-sub">Visas de no inmigrante</h3>

                <p class="many-text">Estas visas están destinadas a personas que desean visitar
                    los Estados Unidos por un período de tiempo limitado y luego regresar a su país de origen. Algunos
                    ejemplos comunes de visas de no inmigrante incluyen:
                </p>
                <ol style="margin-left: 20px">
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Visa de turismo (B1/B2)</strong>: Esta
                            visa permite a los visitantes ingresar a Estados
                            Unidos con fines turísticos, de negocios o para recibir tratamiento médico. Su vigencia suele
                            ser de 6 meses a 10 años, dependiendo de la situación del solicitante.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Visa de estudiante (F1)</strong>: Esta
                            visa es para estudiantes que desean prepararse en
                            una institución educativa de Estados Unidos. Su duración varía según la duración del programa de
                            estudio, pudiendo ser de varios años.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Visa de intercambio (J1)</strong>: Esta
                            visa está destinada a personas que participan en
                            programas de intercambio cultural, educativo o profesional. Su vigencia depende de la duración
                            del programa específico.</p>
                    </li>
                </ol>

                <h3 class="subtitle-sub">Visas de inmigrante</h3>

                <p class="many-text">Estas visas están diseñadas para aquellos que desean vivir
                    de manera permanente en los Estados Unidos. Algunos ejemplos de visas de inmigrante incluyen:
                </p>

                <ul class="list-categories">
                    <li class="list-item">
                        <p class="many-text"><strong>Visa de residencia permanente (Green
                                Card)</strong>: Esta visa otorga el estatus de
                            residente permanente a una persona, lo que le permite vivir y trabajar en los Estados Unidos
                            indefinidamente. Su vigencia inicial es de 10 años, pero se puede renovar.</p>
                    </li>
                    <li>
                        <p class="many-text"><strong>Visas temporales de trabajo</strong>:
                            Estas visas están dirigidas a personas que desean
                            trabajar en los Estados Unidos por un período de tiempo limitado. Algunos ejemplos de visas
                            temporales de trabajo incluyen:</p>
                    </li>
                </ul>

                <p class="many-text"><strong>Visa H-1B</strong>: Esta visa se otorga a
                    profesionales extranjeros altamente calificados que van a trabajar en ocupaciones especializadas. Su
                    vigencia inicial es de 3 años, con la posibilidad de extenderla hasta un máximo de 6 años.
                </p>
                <p class="many-text"><strong>Visa L-1</strong>: Esta visa se concede a
                    empleados de empresas internacionales que son transferidos a una filial, sucursal o subsidiaria en los
                    Estados Unidos. Su duración varía según el tipo de transferencia.
                </p>

                <h2 id="factors-that-afect-visas" class="subtitle">Factores que afectan la vigencia de una visa de Estados
                    Unidos</h2>

                <p class="many-text">La vigencia de una visa de Estados Unidos puede verse
                    afectada por varios factores, entre los cuales se incluyen:
                </p>

                <ul class="list-categories">
                    <li class="list-item">
                        <p class="many-text"><strong>Nacionalidad del solicitante</strong>: La
                            nacionalidad del solicitante puede influir en
                            la duración de la visa. Algunas nacionalidades pueden tener restricciones o limitaciones
                            específicas en cuanto a la duración de la estadía permitida en los Estados Unidos.</p>
                    </li>
                    <li class="list-item">
                        <p class="many-text"><strong>Propósito de la visita</strong>: El
                            propósito de la visita es un factor crucial en la
                            determinación de la vigencia de la visa. Las visas de turismo generalmente tienen una vigencia
                            más corta, ya que se espera que los visitantes regresen a sus países de origen después de un
                            período de tiempo determinado. Por otro lado, las visas de estudio o trabajo pueden tener una
                            vigencia más larga, puesto que se espera que los solicitantes permanezcan en los Estados Unidos
                            durante un período prolongado para cumplir con sus objetivos educativos o laborales.</p>
                    </li>
                    <li class="list-item">
                        <p class="many-text"><strong>Relaciones diplomáticas entre
                                países</strong>: Las relaciones diplomáticas entre los
                            Estados Unidos y otros países pueden tener un impacto en la duración de la vigencia de las
                            visas. En situaciones de tensión política o conflictos, es posible que se impongan restricciones
                            adicionales o que se acorten los períodos de vigencia de las visas para ciudadanos de ciertos
                            países.</p>
                    </li>
                </ul>

                <p class="many-text">Es importante destacar que la duración específica de la
                    vigencia de una visa se determina durante el proceso de solicitud y puede variar en función de los
                    factores mencionados anteriormente, así como de las políticas migratorias y las leyes en vigor en el
                    momento de la solicitud.
                </p>

                <h2 id="electronic-visas-vwp-esta" class="subtitle">Visas electrónicas: Visa Waiver Program (VWP) y
                    Electronic System for Travel Authorization (ESTA)</h2>

                <p class="many-text">Las visas electrónicas son una opción conveniente para
                    aquellos que desean visitar los Estados Unidos por un corto período de tiempo sin necesidad de solicitar
                    una visa tradicional. Dos de las opciones más comunes son el <strong>Visa Waiver Program (VWP)</strong>
                    y <strong>el Electronic System for Travel Authorization (ESTA)</strong>.
                </p>

                <ol style="margin-left: 20px">
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Visa Waiver Program (VWP)</strong>: Este
                            programa de exención permite a los ciudadanos de
                            ciertos países visitar los Estados Unidos por hasta 90 días sin necesidad de obtener una visa.
                            Algunos de los países elegibles para el VWP incluyen el Reino Unido, Alemania, Francia, Japón,
                            España, República Checa y otros más. Sin embargo, es importante tener en cuenta que, aunque
                            estos ciudadanos no necesiten una visa, aún deben solicitar una autorización ESTA antes de
                            viajar.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Electronic System for Travel Authorization
                                (ESTA)</strong>: El <a href="/estados-unidos/p/esta" class="text-link" target="_blank"
                                rel="nofollow">ESTA</a>
                            es un sistema en línea
                            que permite a los ciudadanos de países elegibles solicitar una autorización de viaje antes de su
                            llegada a los Estados Unidos. Esto se aplica tanto para aquellos que viajan bajo el VWP como
                            para aquellos que tienen una visa de no inmigrante válida.</p>
                    </li>
                </ol>

                <p class="many-text">Para comprobar si puedes aplicar al ESTA de EE. UU.,
                    puedes consultar nuestra <a href="https://ivisaviajes.com/a/estados-unidos" class="text-link"
                        target="_blank" rel="nofollow">herramienta de verificación de visados</a>. ¡Si haces parte de este
                    grupo
                    privilegiado aplica ya!
                </p>

                <p class="all-text"><strong>Vigencia de una autorización ESTA</strong>: Una autorización ESTA es válida por
                    un
                    <strong>período de dos años o hasta que el pasaporte del solicitante expire, lo que ocurra
                        primero</strong>. Durante este período, los titulares de una autorización ESTA pueden viajar a los
                    Estados Unidos múltiples veces sin necesidad de solicitar una nueva autorización, siempre que se cumplan
                    las condiciones del programa. Sin embargo, cada visita no puede exceder los 90 días y debe ser para
                    fines de turismo, negocios o tránsito.
                </p>

                <h2 id="electronic-visas-vwp-esta" class="subtitle">Diferencia entre la vigencia de la visa y duración de la
                    estancia permitida</h2>

                <p class="many-text">Es importante comprender la diferencia entre la vigencia
                    de la visa y la duración de la estancia permitida al ingresar a los Estados Unidos, así como el papel
                    del formulario I-94 en el registro de entrada y salida del país.
                </p>

                <ol style="margin-left: 20px">
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Vigencia de la visa</strong>: Es el período durante el cual la visa es
                            válida para
                            ingresar a los Estados Unidos. Se indica en la visa impresa en el pasaporte.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Duración de la estancia permitida</strong>: Es el tiempo máximo que se
                            puede permanecer
                            legalmente en los Estados Unidos una vez que se ha ingresado al país. Se indica en el formulario
                            I-94 emitido al ingresar.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Formulario I-94</strong>: Es el registro electrónico que contiene
                            información sobre la
                            entrada, fecha de vencimiento de la estancia permitida y estatus migratorio del visitante.</p>
                    </li>
                </ol>

                <p class="many-text"><strong>Es relevante tener en cuenta la duración de la estancia permitida indicada en
                        el formulario I-94, ya que es lo que determina cuánto tiempo se puede permanecer en los Estados
                        Unidos, independientemente de la vigencia de la visa</strong>.
                </p>

                <h2 id="how-renovate-extend-visa" class="subtitle">Cómo renovar o extender la vigencia de la visa para
                    ingresar a Estados Unidos</h2>

                <p class="many-text">Renovar o extender la vigencia de una visa de Estados Unidos puede ser necesario si se
                    planea prolongar la estadía en el país más allá de la duración permitida inicialmente. Hay diferentes
                    procesos disponibles para este propósito:
                </p>

                <ol style="margin-left: 20px">
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Renovación de visa</strong>: Si la visa ha expirado y se desea obtener
                            una nueva,
                            generalmente se debe seguir el mismo proceso que al solicitar por primera vez. Esto implica
                            completar el <strong>formulario DS-160</strong>, pagar la tarifa correspondiente y programar una
                            entrevista en la Embajada o el Consulado de Estados Unidos en tu país.</p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Cambio de estatus</strong>: Si estás en Estados Unidos con una visa de
                            no inmigrante y
                            deseas cambiar a otro estatus migratorio, puedes presentar una solicitud de cambio de estatus
                            ante el Servicio de Ciudadanía e Inmigración de Estados Unidos (USCIS). Esto implica completar
                            el <strong>formulario I-539</strong> y pagar la tarifa correspondiente. El cambio de estatus
                            puede permitirte extender tu estadía en los Estados Unidos o cambiar a una visa de inmigrante o
                            de trabajo, por ejemplo. Es importante presentar la solicitud antes de que expire tu estatus
                            actual y cumplir con los requisitos y criterios establecidos por el USCIS. </p>
                    </li>
                    <li style="margin: 16px 0px; list-style-type: decimal;">
                        <p class="many-text"><strong>Extensión de estancia</strong>: Si estás en Estados Unidos con una visa
                            de no inmigrante
                            y necesitas extender tu estadía más allá de la fecha de vencimiento de tu I-94, puedes solicitar
                            una extensión de estancia al USCIS. Debes presentar el formulario <strong>I-539</strong> antes
                            de que expire tu I-94 actual y pagar la tarifa correspondiente. La solicitud debe incluir una
                            justificación válida y documentación de respaldo que demuestre la necesidad de la extensión.</p>
                    </li>
                </ol>

                <h2 id="consecuence-of-stay-more" class="subtitle">Consecuencias de quedarse más allá de la vigencia de una
                    visa</h2>

                <p class="many-text"><strong>Quedarse más allá de la vigencia de una visa puede tener varias consecuencias
                        serias. Esto puede
                        dar como resultado la inadmisibilidad a los Estados Unidos en futuros viajes, lo que significa que
                        se puede negar la entrada al país</strong>. Además, puede dar lugar a la deportación, lo que implica
                    ser expulsado de los Estados Unidos y posiblemente enfrentar prohibiciones de reingreso.
                </p>

                <p class="all-text">Quedarse más allá de la vigencia de la visa puede tener un impacto negativo en futuras
                    solicitudes de visa, ya que las autoridades migratorias pueden considerar la violación de la estancia
                    autorizada como una falta de cumplimiento de las regulaciones migratorias. Por lo tanto, es importante
                    respetar los límites de tiempo establecidos por la visa y tomar las medidas necesarias para renovar,
                    cambiar de estatus o extender la estancia legalmente si es necesario.
                </p>

                <h2 id="how-afect-my-nationality" class="subtitle">¿Cómo afecta mi nacionalidad a la vigencia de mi visa de
                    Estados Unidos?</h2>

                <p class="many-text">La nacionalidad puede afectar la vigencia de una visa de Estados Unidos dependiendo de
                    los acuerdos y políticas diplomáticas entre los países. <strong>Algunas nacionalidades pueden tener
                        acceso a visas de mayor duración o beneficios específicos, mientras que otras pueden tener
                        restricciones adicionales o requisitos más estrictos</strong>.
                </p>

                <h2 id="need-a-visa-if-visit-usa" class="subtitle">¿Necesito una visa si visito Estados Unidos por un corto
                    período de tiempo?</h2>

                <p class="many-text">Si visitas Estados Unidos por un corto período de tiempo, es posible que puedas
                    aprovechar el Visa Waiver Program (VWP) y solicitar una autorización ESTA en lugar de obtener una visa.
                </p>
                <p class="all-text">Estos programas permiten a ciudadanos de ciertos países ingresar a Estados Unidos sin
                    una visa para estancias de hasta 90 días con fines de turismo, negocios o tránsito. En caso de no ser
                    elegible para ninguno de estos programas deberás solicitar tu Visa B1/B2.
                </p>

                <h2 id="how-many-time-visa" class="subtitle">¿Cuánto tiempo de vigencia debe tener mi pasaporte para
                    solicitar una visa de Estados Unidos?</h2>

                <p class="many-text">Tu pasaporte debe tener una validez mínima de seis meses más allá de la fecha prevista
                    de salida de Estados Unidos al solicitar una visa. Es importante asegurarte de que tu pasaporte cumpla
                    con este requisito antes de iniciar el proceso de solicitud de visa.
                </p>

                <h2 id="can-i-travel-USA-if" class="subtitle">¿Puedo viajar a Estados Unidos si mi visa está a punto de
                    caducar?</h2>

                <p class="many-text">Si tu visa está a punto de caducar, generalmente aún puedes viajar a Estados Unidos
                    mientras la visa sea válida. Sin embargo, ten en cuenta que la vigencia de la visa es el período durante
                    el cual puedes ingresar al país, y la duración de tu estancia permitida se determina en el formulario
                    I-94 al ingresar a Estados Unidos.
                </p>

                <h3 class="subtitle-sub">¿Cómo aplicar a tu ESTA con iVisa?</h3>

                <p class="many-text"><strong>El proceso de solicitud del ESTA es muy fácil y rápido con nosotros. ¡Solo
                        tendrás que seguir estos tres pasos y acabarás en menos de 10 minutos!</strong>
                </p>

                <ul class="list-categories">
                    <li class="list-item"><strong>Paso uno</strong>: Completa el formulario de solicitud del visado con tus
                        datos personales.
                        Cuando hayas terminado, podrás seleccionar la rapidez con la que deseas recibir tu visado. Ofrecemos
                        tres opciones diferentes de velocidad.</li>
                    <li class="list-item"><strong>Paso dos</strong>: Revisa si toda la información del formulario de
                        solicitud del visado es
                        correcta. Queremos evitar cualquier inconveniente con tu solicitud. Todos los datos deben coincidir
                        con tus documentos complementarios. Cuando te asegures de que todo es correcto, puedes proceder a
                        abonar la tasa del visado con una tarjeta de crédito/débito o PayPal.</li>
                    <li class="list-item"><strong>Paso tres</strong>: Adjunta todos los documentos complementarios y envía
                        tu formulario de
                        solicitud del visado. Asegúrate de que estén bien escaneados y no contengan manchas. ¡Y eso es todo!
                    </li>
                </ul>

                <p class="many-text">Después de enviar tu solicitud y cuando sea aprobada, recibirás tu ESTA en tu bandeja
                    de entrada de correo electrónico.
                </p>
                <p class="all-text">Imprime y lleva contigo una copia física del documento durante tu viaje y guarda una
                    copia en tu dispositivo electrónico. Deberás presentar el formulario ante las autoridades de inmigración
                    de EE. UU. a tu llegada.
                </p>

                <h2 id="how-long-it-takes" class="subtitle">¿Cuánto tiempo tarda en procesarse una solicitud de visa de
                    Estados Unidos?</h2>

                <p class="many-text">El tiempo de procesamiento de una solicitud de visa de Estados Unidos puede variar
                    según varios factores, como el tipo de visa solicitada, la Embajada o Consulado donde se presenta la
                    solicitud, la época del año y la carga de trabajo del departamento consular.
                </p>
                <p class="all-text">En general, el tiempo de procesamiento puede oscilar desde unos pocos días hasta varias
                    semanas o incluso meses. Es importante tener en cuenta que es aconsejable iniciar el proceso de
                    solicitud de visa con suficiente antelación a la fecha prevista de viaje, ya que el tiempo de
                    procesamiento puede variar y es necesario considerar posibles demoras o solicitar una cita con
                    anticipación.
                </p>
                <p class="all-text">Si tienes alguna consulta no dudes en ponerte en contacto con nuestro equipo de <a
                        href="/contact-us" class="text-link" target="_blank" rel="nofollow">servicio al cliente</a> las 24 horas, los 7 días
                    de la semana, a través del chat en línea o por correo electrónico a <strong>help@iVisa</strong>.</p>
            </div>
        </div>
    </div>

    <div class="info-related">
        <div class="related-container">
            <h2 class="related-title">Artículos relacionados</h2>
            <div class="related-space">
                <a href="/leer-mas" tabindex="-1" style="text-decoration: none">
                    <button class="related-button" type="submit">
                        Leer más
                    </button>
                </a>
            </div>
        </div>
        <div class="card-container">
            <a class="card-0" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/man-working-laptop-hat-outdoor.webp"
                    alt="Guía de tarjetas de llegada: Información clave para viajeros cover image" width="425" height="200"
                    data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/man-working-laptop-hat-outdoor.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Guía de tarjetas de llegada: Información clave para viajeros</h3>
                </div>
            </a>
            <a class="card-1" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/traveler-on-mountain-view.webp"
                    alt="Puntos clave para la carta de invitación: Cómo escribir la invitación perfecta cover image"
                    width="425" height="200" data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/traveler-on-mountain-view.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Puntos clave para la carta de invitación: Cómo escribir la invitación perfecta</h3>
                </div>
            </a>
            <a class="card-2" href="#">
                <img class="xy hg zp ie entered loaded"
                    data-src="https://ivisa.s3.amazonaws.com/website-assets/blog/female-travel-bangkok.webp"
                    alt="Guía completa de eVisas: Definición, proceso, requisitos y más cover image" width="425"
                    height="200" data-ll-status="loaded"
                    src="https://ivisa.s3.amazonaws.com/website-assets/blog/female-travel-bangkok.webp">
                <div class="card-content">
                    <span class="tag">Artículo</span>
                    <h3>Guía completa de eVisas: Definición, proceso, requisitos y más</h3>
                </div>
            </a>

            <div class="other-button">
                <a href="/leer-mas" tabindex="-1" class="viewmore-button">
                    <button class="related-button" type="submit">
                        Leer más
                    </button>
                </a>
            </div>
        </div>
    </div>

    <link href="{{ assets('css/visa-validity.css') }}" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const customSelects = document.querySelectorAll(".custom-select");

            customSelects.forEach(select => {
                const selectedOption = select.querySelector(".selected-option");
                const dropdown = select.querySelector(".dropdown-form");
                const searchInput = select.querySelector(".search-input");
                const optionsList = select.querySelectorAll(".option");

                // Mostrar dropdown en el lugar del select
                selectedOption.addEventListener("click", function () {
                    dropdown.style.display = "block";
                    searchInput.focus();
                });

                // Buscar país en el input
                searchInput.addEventListener("input", function () {
                    const filter = searchInput.value.toLowerCase();
                    optionsList.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        option.style.display = text.includes(filter) ? "flex" : "none";
                    });
                });

                // Seleccionar un país
                optionsList.forEach(option => {
                    option.addEventListener("click", function () {
                        const imgSrc = this.querySelector("img").src;
                        selectedOption.innerHTML = `<img src="${imgSrc}" alt=""> ${this.textContent}`;
                        selectedOption.style.display = "flex";
                        dropdown.style.display = "none";
                        searchInput.value = "";
                        optionsList.forEach(opt => (opt.style.display = "flex"));
                    });
                });

                // Cerrar dropdown si el usuario hace clic fuera
                document.addEventListener("click", function (event) {
                    if (!select.contains(event.target)) {
                        dropdown.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection