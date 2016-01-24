<?php 

    /**
    * A Class for display diferents messages in a current language
    *
    * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
    */
    class LanguageSupport
    {
        private static $actualLanguage;
        private static $allMensagges;

        /**
         * Change the current language witch display messages
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  string $language   'es' or 'en'
         */
        public static function changeLanguage($language = "es")
        {
            if ($language == 'es' || $language == 'en')
            {
                self::$actualLanguage = $language;
            }
            else
            {
                self::$actualLanguage = 'en';
            }
        }

        /**
         * Recover the message from the dictonary
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  string $message Message in english to display with the actual language
         */
        public static function getLang($message = "")
        {
            $text = self::$allMensagges[self::$actualLanguage][$message];

            if (is_null($text))
            {
                return $message;
            }
            else
            {
                return $text;
            }
        }

        /**
         * Recover the actual Language used by the class
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @return string  Language used by the class ('en' or 'es')
         */
        public static function getActualLanguage()
        {
            return self::$actualLanguage;
        }

        /**
         * Change the ^words^ for her traslation in one HTML Document
         * 
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * @param  string   $page    The page to Traslate
         * @return string            The page traslated
         */
        public static function HTMLEvalLanguage($page = '')
        {
            $myPage   = $page;
            $pageFind = $page;
            $posTag1  = stripos($pageFind, '^');

            while ($posTag1 !== false)
            {
                //Cut until the first tag
                $pageFind = substr($pageFind, $posTag1+1);

                //Cind the next tag °
                $posTag2  = stripos($pageFind, '^');

                //Cut until the second tag
                $toTraslate = substr($pageFind, 0, $posTag2);
                $delimiter  = '^' . $toTraslate . '^';
                
                //Replace with new traslation
                $myPage = str_replace($delimiter, self::getLang($toTraslate), $myPage);

                //update the counter data
                $pageFind = substr($pageFind, $posTag2+1);
                $posTag1  = stripos($pageFind, '^');
            }

            return $myPage;
        }

        /**
         * Inicialize the dictionary
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         */
        public static function inicialize()        
        {
            if (!(self::$actualLanguage == 'es' || self::$actualLanguage == 'en'))
            {
                self::$allMensagges = array();

                $leng = "es";
                self::$allMensagges[$leng]["Genesis"] = "GÉNESIS";
                self::$allMensagges[$leng]["Exodus"] = strtoupper("EXODO");
                self::$allMensagges[$leng]["Leviticus"] = strtoupper("LEVÍTICO");
                self::$allMensagges[$leng]["Numbers"] = strtoupper("NÚMEROS");
                self::$allMensagges[$leng]["Deuteronomy"] = strtoupper("DEUTERONOMIO");
                self::$allMensagges[$leng]["Joshua"] = strtoupper("JOSUÉ");
                self::$allMensagges[$leng]["Judges"] = strtoupper("JUECES");
                self::$allMensagges[$leng]["Ruth"] = strtoupper("Rut");
                self::$allMensagges[$leng]["1 Samuel"] = strtoupper("1 Samuel");
                self::$allMensagges[$leng]["2 Samuel"] = strtoupper("2 Samuel");
                self::$allMensagges[$leng]["1 Kings"] = strtoupper("1 Reyes");
                self::$allMensagges[$leng]["2 Kings"] = strtoupper("2 Reyes");
                self::$allMensagges[$leng]["1 Chronicles"] = strtoupper("1 CRÓNICAS");
                self::$allMensagges[$leng]["2 Chronicles"] = strtoupper("2 CRÓNICAS");
                self::$allMensagges[$leng]["Ezra"] = strtoupper("Esdras");
                self::$allMensagges[$leng]["Nehemiah"] = strtoupper("NehemÍas");
                self::$allMensagges[$leng]["Esther"] = strtoupper("Ester");
                self::$allMensagges[$leng]["Job"] = strtoupper("Job");
                self::$allMensagges[$leng]["Psalms"] = strtoupper("Salmo");
                self::$allMensagges[$leng]["Proverbs"] = strtoupper("Proverbios");
                self::$allMensagges[$leng]["Ecclesiastes"] = strtoupper("ECLESTIASTÉS");
                self::$allMensagges[$leng]["Song of Salomon"] = strtoupper("Cantares");
                self::$allMensagges[$leng]["Isaiah"] = strtoupper("IsaÍas");
                self::$allMensagges[$leng]["Jeremiah"] = strtoupper("JeremÍas");
                self::$allMensagges[$leng]["Lamentations"] = strtoupper("Lamentaciones");
                self::$allMensagges[$leng]["Ezekiel"] = strtoupper("Ezequiel");
                self::$allMensagges[$leng]["Daniel"] = strtoupper("Daniel");
                self::$allMensagges[$leng]["Hosea"] = strtoupper("Oseas");
                self::$allMensagges[$leng]["Joel"] = strtoupper("Joel");
                self::$allMensagges[$leng]["Amos"] = strtoupper("AmÓs");
                self::$allMensagges[$leng]["Obadiah"] = strtoupper("AbdÍas");
                self::$allMensagges[$leng]["Jonah"] = strtoupper("JonÁs");
                self::$allMensagges[$leng]["Micah"] = strtoupper("MIQUEAS");
                self::$allMensagges[$leng]["Nahum"] = strtoupper("Nahum");
                self::$allMensagges[$leng]["Habakkuk"] = strtoupper("Habacuc");
                self::$allMensagges[$leng]["Zephaniah"] = strtoupper("SofonÍas");
                self::$allMensagges[$leng]["Haggai"] = strtoupper("Hageo");
                self::$allMensagges[$leng]["Zechariah"] = strtoupper("ZacarÍas");
                self::$allMensagges[$leng]["Malachi"] = strtoupper("MalaquÍas");
                self::$allMensagges[$leng]["Matthew"] = strtoupper("Mateo");
                self::$allMensagges[$leng]["Mark"] = strtoupper("Marcos");
                self::$allMensagges[$leng]["Luke"] = strtoupper("Lucas");
                self::$allMensagges[$leng]["John"] = strtoupper("Juan");
                self::$allMensagges[$leng]["Acts"] = strtoupper("Hechos");
                self::$allMensagges[$leng]["Romans"] = strtoupper("Romanos");
                self::$allMensagges[$leng]["1 Corinthians"] = strtoupper("1 Corintios");
                self::$allMensagges[$leng]["2 Corinthians"] = strtoupper("2 Corintios");
                self::$allMensagges[$leng]["Galatians"] = strtoupper("GÁlatas");
                self::$allMensagges[$leng]["Ephesians"] = strtoupper("Efesios");
                self::$allMensagges[$leng]["Philippians"] = strtoupper("Filipenses");
                self::$allMensagges[$leng]["Colossians"] = strtoupper("Colosenses");
                self::$allMensagges[$leng]["1 Thessalonians"] = strtoupper("1 Tesalonicenses");
                self::$allMensagges[$leng]["2 Thessalonians"] = strtoupper("2 Tesalonicenses");
                self::$allMensagges[$leng]["1 Timothy"] = strtoupper("1 Timoteo");
                self::$allMensagges[$leng]["2 Timothy"] = strtoupper("2 Timoteo");
                self::$allMensagges[$leng]["Titus"] = strtoupper("Tito");
                self::$allMensagges[$leng]["Philemon"] = strtoupper("FilemÓn");
                self::$allMensagges[$leng]["Hebrews"] = strtoupper("Hebreos");
                self::$allMensagges[$leng]["James"] = strtoupper("Santiago");
                self::$allMensagges[$leng]["1 Peter"] = strtoupper("1 Pedro");
                self::$allMensagges[$leng]["2 Peter"] = strtoupper("2 Pedro");
                self::$allMensagges[$leng]["1 John"] = strtoupper("1 Juan");
                self::$allMensagges[$leng]["2 John"] = strtoupper("2 Juan");
                self::$allMensagges[$leng]["3 John"] = strtoupper("3 Juan");
                self::$allMensagges[$leng]["Jude"] = strtoupper("Judas");
                self::$allMensagges[$leng]["Revelation"] = strtoupper("APOCALIPSIS");
                self::$allMensagges[$leng]["Tobit"] = strtoupper("TOBIAS");
                self::$allMensagges[$leng]["1 Maccabees"] = "1 MACABEOS";
                self::$allMensagges[$leng]["2 Maccabees"] = "2 MACABEOS";
                self::$allMensagges[$leng]["Wisdom"] = "SABIDURIA";
                self::$allMensagges[$leng]["Judith"] = "JUDIT";
                self::$allMensagges[$leng]["Baruch"] = "BARUC";
                self::$allMensagges[$leng]["Ecclesiasticus"] = "ECLESIASTICO";
                self::$allMensagges[$leng]["Nothing"] = "NINGUNO";
                self::$allMensagges[$leng]["Insert Baptism"] = "Insertar Bautismo";
                self::$allMensagges[$leng]["Look Baptism"] = "Revisar Bautismo";
                self::$allMensagges[$leng]["About The Child"] = "Datos del Niño";
                self::$allMensagges[$leng]["Names"] = "Nombres";
                self::$allMensagges[$leng]["First Lastname"] = "Primer Apellido";
                self::$allMensagges[$leng]["Second Lastname"] = "Segundo Apellido";
                self::$allMensagges[$leng]["Check Exist"] = "Revisar si existe";
                self::$allMensagges[$leng]["Person"] = "Persona";
                self::$allMensagges[$leng]["Born Date"] = "Fecha de Nacimiento";
                self::$allMensagges[$leng]["Born Place"] = "Lugar de Nacimiento";
                self::$allMensagges[$leng]["Gender"] = "Género";
                self::$allMensagges[$leng]["Legitimate"] = "Legítimo";
                self::$allMensagges[$leng]["Female"] = "Femenino";
                self::$allMensagges[$leng]["Male"] = "Masculino";
                self::$allMensagges[$leng]["Yes"] = "Si";
                self::$allMensagges[$leng]["About The Celebration"] = "Datos De La Celebración";
                self::$allMensagges[$leng]["Church"] = "Iglesia";
                self::$allMensagges[$leng]["Rector"] = "Sacerdote";
                self::$allMensagges[$leng]["Baptism Date"] = "Fecha de Bautismo";
                self::$allMensagges[$leng]["About The Father"] = "Datos Del Padre";
                self::$allMensagges[$leng]["Father"] = "Padre";
                self::$allMensagges[$leng]["Mother"] = "Madre";
                self::$allMensagges[$leng]["About The Mother"] = "Datos de la Madre";
                self::$allMensagges[$leng]["About The Godparents"] = "Datos De Los Padrinos";
                self::$allMensagges[$leng]["Godfather"] = "Padrino";
                self::$allMensagges[$leng]["Godmother"] = "Madrina";
                self::$allMensagges[$leng]["About The Church Registry"] = "Datos Del Registro De La Parroquia";
                self::$allMensagges[$leng]["About The Civil Registry"] = "Datos Del Registro Civil";
                self::$allMensagges[$leng]["Book"] = "Libro";
                self::$allMensagges[$leng]["Page"] = "Página";
                self::$allMensagges[$leng]["Number"] = "Número";
                self::$allMensagges[$leng]["Office"] = "Oficina";
                self::$allMensagges[$leng]["characters"] = "caracteres";
                self::$allMensagges[$leng]["date"] = "fecha";
                self::$allMensagges[$leng]["Reverse"] = "Vuelta";
                self::$allMensagges[$leng]["Welcome To"] = "Bienvenidos a";
                self::$allMensagges[$leng]["Home"] = "Inicio";
                self::$allMensagges[$leng]["Go To Menu"] = "Ir al Menú";
                self::$allMensagges[$leng]["Insert New Registry"] = "Insertar Nuevo Registro";
                self::$allMensagges[$leng]["Baptism"] = "Bautismo";
                self::$allMensagges[$leng]["Communion"] = "Comunión";
                self::$allMensagges[$leng]["Confirmation"] = "Confirmación";
                self::$allMensagges[$leng]["Marriage"] = "Matrimonio";
                self::$allMensagges[$leng]["Proof"] = "Comprobante";
                self::$allMensagges[$leng]["Menu"] = "Menú";
                self::$allMensagges[$leng]["Logout"] = "Cerrar Sesión";
                self::$allMensagges[$leng]["Baptism Menu"] = "Menú de Bautismo";
                self::$allMensagges[$leng]["Show All"] = "Mostrar Todos";
                self::$allMensagges[$leng]["Add"] = "Agregar";
                self::$allMensagges[$leng]["Advanced Search"] = "Búsqueda Avanzada";
                self::$allMensagges[$leng]["Simple Search"] = "Búsqueda Simple";
                self::$allMensagges[$leng]["Search"] = "Buscar";
                self::$allMensagges[$leng]["Next"] = "Siguiente";
                self::$allMensagges[$leng]["Previus"] = "Anterior";
                self::$allMensagges[$leng]["Begin"] = "Primera";
                self::$allMensagges[$leng]["Last"] = "Última";
                self::$allMensagges[$leng]["No Contest Found"] = "No se encontró contenido";
                self::$allMensagges[$leng]["Latest"] = "Reciente";
                self::$allMensagges[$leng]["Lastname Child"] = "Apellido de Niño";
                self::$allMensagges[$leng]["Name Church"] = "Nombre de Parroquia";
                self::$allMensagges[$leng]["Fullname Child"] = "Nombre del Niño";
                self::$allMensagges[$leng]["Fullname Father"] = "Nombre del Padre";
                self::$allMensagges[$leng]["Fullname Mother"] = "Nombre de la Madre";
                self::$allMensagges[$leng]["Options"] = "Opciones";
                self::$allMensagges[$leng]["Baptism Table"] = "Tabla de Bautismo";
                self::$allMensagges[$leng]["Sort By"] = "Ordenar Por";
                self::$allMensagges[$leng]["Names of Child"] = "Nombres del Niño";
                self::$allMensagges[$leng]["of Child"] = "del Niño";
                self::$allMensagges[$leng]["Baptism Book"] = "Libro de Bautismo";
                self::$allMensagges[$leng]["Baptism Page"] = "Página de Bautismo";
                self::$allMensagges[$leng]["Baptism Number"] = "Número de Bautismo";
                self::$allMensagges[$leng]["Add Relation Church-Rector"] = "Agregar Relación Iglesia-Sacerdote";
                self::$allMensagges[$leng]["Insert New Relation of Former Rector From Church"] = "Agrega una nueva relación entre un antiguo sacerdote y una iglesia";
                self::$allMensagges[$leng]["Save"] = "Guardar";
                self::$allMensagges[$leng]["Cancel"] = "Cancelar";
                self::$allMensagges[$leng]["Baptism Cert"] = "Acta de Bautismo";
                self::$allMensagges[$leng]["Full"] = "Completa";
                self::$allMensagges[$leng]["To Print"] = "Para Imprimir";
                self::$allMensagges[$leng]["Return"] = "Regresar";
                self::$allMensagges[$leng]["Copy Baptism Cert"] = "Copia de Acta de Bautismo";
                self::$allMensagges[$leng]["Insert Church"] = "Agregar Iglesia";
                self::$allMensagges[$leng]["Change Church"] = "Cambiar Iglesia";
                self::$allMensagges[$leng]["Look Church"] = "Revisar Iglesia";
                self::$allMensagges[$leng]["About The Church"] = "Datos de la Iglesia";
                self::$allMensagges[$leng]["Name"] = "Nombre";
                self::$allMensagges[$leng]["Type"] = "Tipo";
                self::$allMensagges[$leng]["Code"] = "Código";
                self::$allMensagges[$leng]["Address"] = "Domicilio";
                self::$allMensagges[$leng]["Colony"] = "Colonia";
                self::$allMensagges[$leng]["Postal Code"] = "Código Postal";
                self::$allMensagges[$leng]["Phone Number"] = "Número de Teléfono";
                self::$allMensagges[$leng]["About The Registry With Other Church"] = "Datos Del Registro Con Otras Parroquias";
                self::$allMensagges[$leng]["Vicar"] = "Vicaría";
                self::$allMensagges[$leng]["Dean"] = "Decanato";
                self::$allMensagges[$leng]["City"] = "Ciudad";
                self::$allMensagges[$leng]["Niche"] = "Nichos";
                self::$allMensagges[$leng]["About The Niche Structure"] = "Sobre La Estructura Ee Los Nichos";
                self::$allMensagges[$leng]["Maximum Columns"] = "Máximas Columnas";
                self::$allMensagges[$leng]["Maximus Rows"] = "Máximas Filas";
                self::$allMensagges[$leng]["Size Inside"] = "Tamaño Interior";
                self::$allMensagges[$leng]["Have Niches"] = "Tiene Nichos";
                self::$allMensagges[$leng]["numbers"] = "números";
                self::$allMensagges[$leng]["Church Menu"] = "Menú de Iglesia";
                self::$allMensagges[$leng]["Church Table"] = "Tabla de Iglesias";
                self::$allMensagges[$leng]["Rector Menu"] = "Menú de Sacerdotes";
                self::$allMensagges[$leng]["The Church Called"] = "La iglesia llamada";
                self::$allMensagges[$leng]["has having the next rectors in his history"] = "ha tenido los siguientes sacerdotes en su historia";
                self::$allMensagges[$leng]["Add Relation"] = "Agregar Relación";
                self::$allMensagges[$leng]["Go To Rector Menu"] = "Ir al menú de Sacerdotes";
                self::$allMensagges[$leng]["Go To Church Menu"] = "Ir al menú de Iglesias";
                self::$allMensagges[$leng]["No Rectors in this Church"] = "No hay Sacerdotes en esta Iglesia";
                self::$allMensagges[$leng]["Lastname Rector"] = "Apellido del Sacerdote";
                self::$allMensagges[$leng]["Actual Church"] = "Iglesia Actual";
                self::$allMensagges[$leng]["Rector Table"] = "Tabla de Sacerdotes";
                self::$allMensagges[$leng]["Status"] = "Estado";
                self::$allMensagges[$leng]["Position"] = "Cargo";
                self::$allMensagges[$leng]["Insert City"] = "Insertar Ciudad";
                self::$allMensagges[$leng]["Insert New City"] = "Insertar Nueva Ciudad";
                self::$allMensagges[$leng]["State"] = "Estado";
                self::$allMensagges[$leng]["Insert State"] = "Insertar Estado";
                self::$allMensagges[$leng]["Insert New State"] = "Insertar Nuevo Estado";
                self::$allMensagges[$leng]["ShortName"] = "Abreviatura";
                self::$allMensagges[$leng]["Contry"] = "Pais";
                self::$allMensagges[$leng]["Insert Dean"] = "Insertar Decanato";
                self::$allMensagges[$leng]["Insert New Dean"] = "Insertar Nuevo Decanato";
                self::$allMensagges[$leng]["Insert Vicar"] = "Insertar Vicaría";
                self::$allMensagges[$leng]["Insert New Vicar"] = "Insertar Nuevo Vicaría";
                self::$allMensagges[$leng]["Proof Talks"] = "Comprobante de Pláticas";
                self::$allMensagges[$leng]["Not Father"] = "Sin Padre";
                self::$allMensagges[$leng]["Not Mother"] = "Sin Madre";
                self::$allMensagges[$leng]["Person List"] = "Lista de Personas";
                self::$allMensagges[$leng]["Select One Person to Get Data"] = "Selecione una persona para obtener datos";
                self::$allMensagges[$leng]["Isn't Here"] = "No está aquí";
                self::$allMensagges[$leng]["Insert Rector"] = "Insertar Sacerdote";
                self::$allMensagges[$leng]["Change Rector"] = "Cambiar Sacerdote";
                self::$allMensagges[$leng]["Look Rector"] = "Revisar Sacerdote";
                self::$allMensagges[$leng]["About The Rector"] = "Datos del Sacerdote";
                self::$allMensagges[$leng]["About Actual State"] = "Sobre su estado actual";
                self::$allMensagges[$leng]["Last/Actual Church"] = "Última/Actual Iglesia";
                self::$allMensagges[$leng]["Active"] = "Activo";
                self::$allMensagges[$leng]["Innactive"] = "Inactivo";
                self::$allMensagges[$leng]["The Rector Called"] = "El Sacerdote llamado";
                self::$allMensagges[$leng]["has having in the next church in her history"] = "ha estado en las siguientes iglesias en su historia";
                self::$allMensagges[$leng]["Insert Office Civil Registry"] = "Insertar Oficina del Registro Civil";
                self::$allMensagges[$leng]["Config"] = "Configurar";
                self::$allMensagges[$leng]["Config User Account"] = "Configurar Cuenta de Usuario";
                self::$allMensagges[$leng]["Language"] = "Lenguaje";
                self::$allMensagges[$leng]["Spanish"] = "Español";
                self::$allMensagges[$leng]["English"] = "Inglés";
                self::$allMensagges[$leng]["Successful Change"] = "Cambio Exitoso";
                self::$allMensagges[$leng]["Communion Menu"] = "Menú de Comunión";
                self::$allMensagges[$leng]["Communion Table"] = "Tabla de Comuniones";
                self::$allMensagges[$leng]["Communion Date"] = "Fecha de Comunión";
                self::$allMensagges[$leng]["Communion Book"] = "Libro de Comunión";
                self::$allMensagges[$leng]["Communion Page"] = "Página de Comunión";
                self::$allMensagges[$leng]["Insert Communion"] = "Insertar Comunión";
                self::$allMensagges[$leng]["Communion Number"] = "Número de Comunión";
                self::$allMensagges[$leng]["Look Communion"] = "Ver Comunión";
                self::$allMensagges[$leng]["Update Communion"] = "Actualizar Comunión";
                self::$allMensagges[$leng]["Communion Cert"] = "Acta de Comunión";
                self::$allMensagges[$leng]["Copy Communion Cert"] = "Copia de Acta de Comunión";
                self::$allMensagges[$leng]["Confirmation Menu"] = "Menú de Confirmación";
                self::$allMensagges[$leng]["Confirmation Table"] = "Tabla de Confirmación";
                self::$allMensagges[$leng]["Confirmation Date"] = "Fecha de Confirmación";
                self::$allMensagges[$leng]["Confirmation Book"] = "Libro de Confirmación";
                self::$allMensagges[$leng]["Confirmation Page"] = "Página de Confirmación";
                self::$allMensagges[$leng]["Insert Confirmation"] = "Insertar Confirmación";
                self::$allMensagges[$leng]["Confirmation Number"] = "Número de Confirmación";
                self::$allMensagges[$leng]["Look Confirmation"] = "Ver Confirmación";
                self::$allMensagges[$leng]["Update Confirmation"] = "Actualizar Confirmación";
                self::$allMensagges[$leng]["Confirmation Cert"] = "Acta de Confirmación";
                self::$allMensagges[$leng]["Copy Confirmation Cert"] = "Copia de Acta de Confirmación";
                self::$allMensagges[$leng]["Marriage Menu"] = "Menú de Matrimonio";
                self::$allMensagges[$leng]["Marriage Table"] = "Tabla de Matrimonio";
                self::$allMensagges[$leng]["Marriage Date"] = "Fecha de Matrimonio";
                self::$allMensagges[$leng]["Marriage Book"] = "Libro de Matrimonio";
                self::$allMensagges[$leng]["Marriage Page"] = "Página de Matrimonio";
                self::$allMensagges[$leng]["Insert Marriage"] = "Insertar Matrimonio";
                self::$allMensagges[$leng]["Marriage Number"] = "Número de Matrimonio";
                self::$allMensagges[$leng]["Look Marriage"] = "Ver Matrimonio";
                self::$allMensagges[$leng]["Update Marriage"] = "Actualizar Matrimonio";
                self::$allMensagges[$leng]["Fullname Boyfriend"] = "Nombre Novio";
                self::$allMensagges[$leng]["Fullname Girlfriend"] = "Nombre Novia";
                self::$allMensagges[$leng]["Lastname Boyfriend"] = "Apellido Novio";
                self::$allMensagges[$leng]["Lastname Girlfriend"] = "Apellido Novia";
                self::$allMensagges[$leng]["About The Boyfriend"] = "Datos Sobre El Novio";
                self::$allMensagges[$leng]["About The Girlfriend"] = "Datos Sobre La Novia";
                self::$allMensagges[$leng]["About The Witness"] = "Datos Sobre Los Testigos";
                self::$allMensagges[$leng]["Witness1"] = "Testigo 1";
                self::$allMensagges[$leng]["Witness2"] = "Testigo 2";
                self::$allMensagges[$leng]["of Girlfriend"] = "de la Novia";
                self::$allMensagges[$leng]["of Boyfriend"] = "del Novio";
                self::$allMensagges[$leng]["Names of Boyfriend"] = "Nombres del Novio";
                self::$allMensagges[$leng]["Names of Girlfriend"] = "Nombres de la Novia";
                self::$allMensagges[$leng]["Church Marriage"] = "Iglesia donde se Celebró";
                self::$allMensagges[$leng]["Church Process"] = "Iglesia donde se Tramitó";
                self::$allMensagges[$leng]["Update Marriage"] = "Actualizar Matrimonio";
                self::$allMensagges[$leng]["Marriage Constancy"] = "Constancia de Matrimonio";
                self::$allMensagges[$leng]["Copy Marriage Cert"] = "Certificado de Matrimonio";
                self::$allMensagges[$leng]["Marriage Notice"] = "Aviso Matrimonial";
                self::$allMensagges[$leng]["Marriage Exhort"] = "Exhorto Matrimonial";
                self::$allMensagges[$leng]["Marriage Traslation"] = "Traslado Matrimonial";
                self::$allMensagges[$leng]["Proof Menu"] = "Menú de Comprobantes";
                self::$allMensagges[$leng]["Proof Table"] = "Tabla de Comprobantes";
                self::$allMensagges[$leng]["Look Proof"] = "Ver Comprobante";
                self::$allMensagges[$leng]["City Address"] = "Ciudad del Domicilio";
                self::$allMensagges[$leng]["About The Godfather"] = "Datos Del Padrino";
                self::$allMensagges[$leng]["About The Godmother"] = "Datos De La Madrina";
                self::$allMensagges[$leng]["Change Proof"] = "Cambiar Comprobante";
                self::$allMensagges[$leng]["Insert Proof"] = "Insertar Comprobante";
                self::$allMensagges[$leng]["Defuntion"] = "Defunción";
                self::$allMensagges[$leng]["Defuntion Table"] = "Tabla de Defunción";
                self::$allMensagges[$leng]["Fullname"] = "Nombre Completo";
                self::$allMensagges[$leng]["Lastname"] = "Apellidos";
                self::$allMensagges[$leng]["Defuntion Date"] = "Fecha de Defunción";
                self::$allMensagges[$leng]["of Owner"] = "Del Propietario";
                self::$allMensagges[$leng]["Names of Owner"] = "Nombres del Propietario";
                self::$allMensagges[$leng]["Defuntion Menu"] = "Menú de Defunción";
                self::$allMensagges[$leng]["About The Person"] = "Datos Sobre La Persona";
                self::$allMensagges[$leng]["Crypt"] = "Cripta";
                self::$allMensagges[$leng]["Have Crypt"] = "Tiene Cripta";
                self::$allMensagges[$leng]["Column"] = "Columna";
                self::$allMensagges[$leng]["Row"] = "Fila";
                self::$allMensagges[$leng]["Look Defuntion"] = "Ver Defunción";
                self::$allMensagges[$leng]["Change Defuntion"] = "Cambiar Defunción";
                self::$allMensagges[$leng]["Users"] = "Usuarios";
                self::$allMensagges[$leng]["All"] = "Todos";
                self::$allMensagges[$leng]["User Menu"] = "Menú de Usuarios";
                self::$allMensagges[$leng]["User Table"] = "Tabla de Usuarios";
                self::$allMensagges[$leng]["Online"] = "En Linea";
                self::$allMensagges[$leng]["Offline"] = "Desconectado";
                self::$allMensagges[$leng]["Username"] = "Nombre de Usuario";
                self::$allMensagges[$leng]["Only Online"] = "Sólo Usuarios en Linea";
                self::$allMensagges[$leng]["Select one Contact"] = "Selecione un Contacto";
                self::$allMensagges[$leng]["Message whit User"] = "Mensajes con el Usuario";
                self::$allMensagges[$leng]["Send"] = "Enviar";
                self::$allMensagges[$leng]["Message To"] = "Mensaje para";
                self::$allMensagges[$leng]["of maximum 150 characters"] = "de máximo 150 caracteres";
                self::$allMensagges[$leng]["User"] = "Usuario";
                self::$allMensagges[$leng]["Password"] = "Contraseña";
                self::$allMensagges[$leng]["Password Again"] = "Repetir Contraseña";
                self::$allMensagges[$leng]["Change Baptism"] = "Cambiar Bautismo";
                self::$allMensagges[$leng]["Change Communion"] = "Cambiar Comunión";
                self::$allMensagges[$leng]["Change Confirmation"] = "Cambiar Confirmación";
                self::$allMensagges[$leng]["Change Marriage"] = "Cambiar Matrimonio";
                self::$allMensagges[$leng]["Insert Defuntion"] = "Insertar Defunción";
                self::$allMensagges[$leng]["Change Marriage"] = "Actualizar Matrimonio";
                self::$allMensagges[$leng]["Notice Of Privacy"] = "Aviso de Privacidad";
                self::$allMensagges[$leng]["Check Our Notice Of Privacy"] = "Revise Nuestro Aviso de Privacidad";
                self::$allMensagges[$leng]["Update The"] = "Actualizar Datos";
                self::$allMensagges[$leng]["Print Setup"] = "De Impresión";
                self::$allMensagges[$leng]["About The Crypt Structure"] = "Sobre la Estructura de la Cripta";
                self::$allMensagges[$leng]["Insert User"] = "Insertar Usuario";
                self::$allMensagges[$leng]["About The User"] = "Datos del Usuario";
                self::$allMensagges[$leng]["No Messages"] = "No hay mensajes";
                self::$allMensagges[$leng]["Envelope Church"] = "Sobre para Carta de Iglesia";
                self::$allMensagges[$leng]["About The Baptism Registry"] = "Sobre el Registro del Bautismo";

                $leng = "en";
                self::$allMensagges[$leng]["Genesis"] = strtoupper("Genesis");
                self::$allMensagges[$leng]["Exodus"] = strtoupper("Exodus");
                self::$allMensagges[$leng]["Leviticus"] = strtoupper("Leviticus");
                self::$allMensagges[$leng]["Numbers"] = strtoupper("Numbers");
                self::$allMensagges[$leng]["Deuteronomy"] = strtoupper("Deuteronomy");
                self::$allMensagges[$leng]["Joshua"] = strtoupper("Joshua");
                self::$allMensagges[$leng]["Judges"] = strtoupper("Judges");
                self::$allMensagges[$leng]["Ruth"] = strtoupper("Ruth");
                self::$allMensagges[$leng]["1 Samuel"] = strtoupper("1 Samuel");
                self::$allMensagges[$leng]["2 Samuel"] = strtoupper("2 Samuel");
                self::$allMensagges[$leng]["1 Kings"] = strtoupper("1 Kings");
                self::$allMensagges[$leng]["2 Kings"] = strtoupper("2 Kings");
                self::$allMensagges[$leng]["1 Chronicles"] = strtoupper("1 Chronicles");
                self::$allMensagges[$leng]["2 Chronicles"] = strtoupper("2 Chronicles");
                self::$allMensagges[$leng]["Ezra"] = strtoupper("Ezra");
                self::$allMensagges[$leng]["Nehemiah"] = strtoupper("Nehemiah");
                self::$allMensagges[$leng]["Esther"] = strtoupper("Esther");
                self::$allMensagges[$leng]["Job"] = strtoupper("Job");
                self::$allMensagges[$leng]["Psalms"] = strtoupper("Psalms");
                self::$allMensagges[$leng]["Proverbs"] = strtoupper("Proverbs");
                self::$allMensagges[$leng]["Ecclesiastes"] = strtoupper("Ecclesiastes");
                self::$allMensagges[$leng]["Song of Salomon"] = strtoupper("Song of Salomon");
                self::$allMensagges[$leng]["Isaiah"] = strtoupper("Isaiah");
                self::$allMensagges[$leng]["Jeremiah"] = strtoupper("Jeremiah");
                self::$allMensagges[$leng]["Lamentations"] = strtoupper("Lamentations");
                self::$allMensagges[$leng]["Ezekiel"] = strtoupper("Ezekiel");
                self::$allMensagges[$leng]["Daniel"] = strtoupper("Daniel");
                self::$allMensagges[$leng]["Hosea"] = strtoupper("Hosea");
                self::$allMensagges[$leng]["Joel"] = strtoupper("Joel");
                self::$allMensagges[$leng]["Amos"] = strtoupper("Amos");
                self::$allMensagges[$leng]["Obadiah"] = strtoupper("Obadiah");
                self::$allMensagges[$leng]["Jonah"] = strtoupper("Jonah");
                self::$allMensagges[$leng]["Micah"] = strtoupper("Micah");
                self::$allMensagges[$leng]["Nahum"] = strtoupper("Nahum");
                self::$allMensagges[$leng]["Habakkuk"] = strtoupper("Habakkuk");
                self::$allMensagges[$leng]["Zephaniah"] = strtoupper("Zephaniah");
                self::$allMensagges[$leng]["Haggai"] = strtoupper("Haggai");
                self::$allMensagges[$leng]["Zechariah"] = strtoupper("Zechariah");
                self::$allMensagges[$leng]["Malachi"] = strtoupper("Malachi");
                self::$allMensagges[$leng]["Matthew"] = strtoupper("Matthew");
                self::$allMensagges[$leng]["Mark"] = strtoupper("Mark");
                self::$allMensagges[$leng]["Luke"] = strtoupper("Luke");
                self::$allMensagges[$leng]["John"] = strtoupper("John");
                self::$allMensagges[$leng]["Acts"] = strtoupper("Acts");
                self::$allMensagges[$leng]["Romans"] = strtoupper("Romans");
                self::$allMensagges[$leng]["1 Corinthians"] = strtoupper("1 Corinthians");
                self::$allMensagges[$leng]["2 Corinthians"] = strtoupper("2 Corinthians");
                self::$allMensagges[$leng]["Galatians"] = strtoupper("Galatians");
                self::$allMensagges[$leng]["Ephesians"] = strtoupper("Ephesians");
                self::$allMensagges[$leng]["Philippians"] = strtoupper("Philippians");
                self::$allMensagges[$leng]["Colossians"] = strtoupper("Colossians");
                self::$allMensagges[$leng]["1 Thessalonians"] = strtoupper("1 Thessalonians");
                self::$allMensagges[$leng]["2 Thessalonians"] = strtoupper("2 Thessalonians");
                self::$allMensagges[$leng]["1 Timothy"] = strtoupper("1 Timothy");
                self::$allMensagges[$leng]["2 Timothy"] = strtoupper("2 Timothy");
                self::$allMensagges[$leng]["Titus"] = strtoupper("Titus");
                self::$allMensagges[$leng]["Philemon"] = strtoupper("Philemon");
                self::$allMensagges[$leng]["Hebrews"] = strtoupper("Hebrews");
                self::$allMensagges[$leng]["James"] = strtoupper("James");
                self::$allMensagges[$leng]["1 Peter"] = strtoupper("1 Peter");
                self::$allMensagges[$leng]["2 Peter"] = strtoupper("2 Peter");
                self::$allMensagges[$leng]["1 John"] = strtoupper("1 John");
                self::$allMensagges[$leng]["2 John"] = strtoupper("2 John");
                self::$allMensagges[$leng]["3 John"] = strtoupper("3 John");
                self::$allMensagges[$leng]["Jude"] = strtoupper("Jude");
                self::$allMensagges[$leng]["Revelation"] = strtoupper("Revelation");
                self::$allMensagges[$leng]["Tobit"] = strtoupper("Tobit");
                self::$allMensagges[$leng]["1 Maccabees"] = strtoupper("1 Maccabees");
                self::$allMensagges[$leng]["2 Maccabees"] = strtoupper("2 Maccabees");
                self::$allMensagges[$leng]["Wisdom"] = strtoupper("Wisdom");
                self::$allMensagges[$leng]["Judith"] = strtoupper("Judith");
                self::$allMensagges[$leng]["Baruch"] = strtoupper("Baruch");
                self::$allMensagges[$leng]["Ecclesiasticus"] = strtoupper("Ecclesiasticus");
                self::$allMensagges[$leng]["Nothing"] = strtoupper("Nothing");
                self::$allMensagges[$leng]["Insert Baptism"] = "Insert Baptism";
                self::$allMensagges[$leng]["Look Baptism"] = "Look Baptism";
                self::$allMensagges[$leng]["About The Child"] = "About The Child";
                self::$allMensagges[$leng]["Names"] = "Names";
                self::$allMensagges[$leng]["First Lastname"] = "First Lastname";
                self::$allMensagges[$leng]["Second Lastname"] = "Second Lastname";
                self::$allMensagges[$leng]["Check Exist"] = "Check Exist";
                self::$allMensagges[$leng]["Person"] = "Person";
                self::$allMensagges[$leng]["Born Date"] = "Born Date";
                self::$allMensagges[$leng]["Born Place"] = "Born Place";
                self::$allMensagges[$leng]["Gender"] = "Gender";
                self::$allMensagges[$leng]["Legitimate"] = "Legitimate";
                self::$allMensagges[$leng]["Female"] = "Female";
                self::$allMensagges[$leng]["Male"] = "Male";
                self::$allMensagges[$leng]["Yes"] = "Yes";
                self::$allMensagges[$leng]["About The Celebration"] = "About The Celebration";
                self::$allMensagges[$leng]["Church"] = "Church";
                self::$allMensagges[$leng]["Rector"] = "Rector";
                self::$allMensagges[$leng]["Baptism Date"] = "Baptism Date";
                self::$allMensagges[$leng]["About The Father"] = "About The Father";
                self::$allMensagges[$leng]["Father"] = "Father";
                self::$allMensagges[$leng]["Mother"] = "Mother";
                self::$allMensagges[$leng]["About The Mother"] = "About The Mother";
                self::$allMensagges[$leng]["About The Godparents"] = "About The Godparents";
                self::$allMensagges[$leng]["Godfather"] = "Godfather";
                self::$allMensagges[$leng]["Godmother"] = "Godmother";
                self::$allMensagges[$leng]["About The Church Registry"] = "About The Church Registry";
                self::$allMensagges[$leng]["About The Civil Registry"] = "About The Civil Registry";
                self::$allMensagges[$leng]["Book"] = "Book";
                self::$allMensagges[$leng]["Page"] = "Page";
                self::$allMensagges[$leng]["Number"] = "Number";
                self::$allMensagges[$leng]["Office"] = "Office";
                self::$allMensagges[$leng]["characters"] = "characters";
                self::$allMensagges[$leng]["date"] = "date";
                self::$allMensagges[$leng]["Reverse"] = "Reverse";
                self::$allMensagges[$leng]["Welcome To"] = "Welcome To";
                self::$allMensagges[$leng]["Home"] = "Home";
                self::$allMensagges[$leng]["Go To Menu"] = "Go To Menu";
                self::$allMensagges[$leng]["Insert New Registry"] = "Insert New Registry";
                self::$allMensagges[$leng]["Baptism"] = "Baptism";
                self::$allMensagges[$leng]["Communion"] = "Communion";
                self::$allMensagges[$leng]["Confirmation"] = "Confirmation";
                self::$allMensagges[$leng]["Marriage"] = "Marriage";
                self::$allMensagges[$leng]["Proof"] = "Proof";
                self::$allMensagges[$leng]["Menu"] = "Menu";
                self::$allMensagges[$leng]["Logout"] = "Logout";
                self::$allMensagges[$leng]["Baptism Menu"] = "Baptism Menu";
                self::$allMensagges[$leng]["Show All"] = "Show All";
                self::$allMensagges[$leng]["Add"] = "Add";
                self::$allMensagges[$leng]["Advanced Search"] = "Advanced Search";
                self::$allMensagges[$leng]["Simple Search"] = "Simple Search";
                self::$allMensagges[$leng]["Search"] = "Search";
                self::$allMensagges[$leng]["Next"] = "Next";
                self::$allMensagges[$leng]["Previus"] = "Previus";
                self::$allMensagges[$leng]["Begin"] = "Begin";
                self::$allMensagges[$leng]["Last"] = "Last";
                self::$allMensagges[$leng]["No Contest Found"] = "No Contest Found";
                self::$allMensagges[$leng]["Latest"] = "Latest";
                self::$allMensagges[$leng]["Lastname Child"] = "Lastname Child";
                self::$allMensagges[$leng]["Name Church"] = "Name Church";
                self::$allMensagges[$leng]["Fullname Child"] = "Fullname Child";
                self::$allMensagges[$leng]["Fullname Father"] = "Fullname Father";
                self::$allMensagges[$leng]["Fullname Mother"] = "Fullname Mother";
                self::$allMensagges[$leng]["Options"] = "Options";
                self::$allMensagges[$leng]["Baptism Table"] = "Baptism Table";
                self::$allMensagges[$leng]["Sort By"] = "Sort By";
                self::$allMensagges[$leng]["Names of Child"] = "Names of Child";
                self::$allMensagges[$leng]["of Child"] = "of Child";
                self::$allMensagges[$leng]["Baptism Book"] = "Baptism Book";
                self::$allMensagges[$leng]["Baptism Page"] = "Baptism Page";
                self::$allMensagges[$leng]["Baptism Number"] = "Baptism Number";
                self::$allMensagges[$leng]["Add Relation Church-Rector"] = "Add Relation Church-Rector";
                self::$allMensagges[$leng]["Insert New Relation of Former Rector From Church"] = "Insert New Relation of Former Rector From Church";
                self::$allMensagges[$leng]["Save"] = "Save";
                self::$allMensagges[$leng]["Cancel"] = "Cancel";
                self::$allMensagges[$leng]["Baptism Cert"] = "Baptism Cert";
                self::$allMensagges[$leng]["Full"] = "Full";
                self::$allMensagges[$leng]["To Print"] = "To Print";
                self::$allMensagges[$leng]["Return"] = "Return";
                self::$allMensagges[$leng]["Copy Baptism Cert"] = "Copy Baptism Cert";
                self::$allMensagges[$leng]["Insert Church"] = "Insert Church";
                self::$allMensagges[$leng]["Change Church"] = "Change Church";
                self::$allMensagges[$leng]["Look Church"] = "Look Church";
                self::$allMensagges[$leng]["About The Church"] = "About The Church";
                self::$allMensagges[$leng]["Name"] = "Name";
                self::$allMensagges[$leng]["Type"] = "Type";
                self::$allMensagges[$leng]["Code"] = "Code";
                self::$allMensagges[$leng]["Address"] = "Address";
                self::$allMensagges[$leng]["Colony"] = "Colony";
                self::$allMensagges[$leng]["Postal Code"] = "Postal Code";
                self::$allMensagges[$leng]["Phone Number"] = "Phone Number";
                self::$allMensagges[$leng]["About The Registry With Other Church"] = "About The Registry With Other Church";
                self::$allMensagges[$leng]["Vicar"] = "Vicar";
                self::$allMensagges[$leng]["Dean"] = "Dean";
                self::$allMensagges[$leng]["City"] = "City";
                self::$allMensagges[$leng]["Niche"] = "Niche";
                self::$allMensagges[$leng]["About The Niche Structure"] = "About The Niche Structure";
                self::$allMensagges[$leng]["Maximum Columns"] = "Maximum Columns";
                self::$allMensagges[$leng]["Maximus Rows"] = "Maximus Rows";
                self::$allMensagges[$leng]["Size Inside"] = "Size Inside";
                self::$allMensagges[$leng]["Have Niches"] = "Have Niches";
                self::$allMensagges[$leng]["numbers"] = "numbers";
                self::$allMensagges[$leng]["Church Menu"] = "Church Menu";
                self::$allMensagges[$leng]["Church Table"] = "Church Table";
                self::$allMensagges[$leng]["Rector Menu"] = "Rector Menu";
                self::$allMensagges[$leng]["The Church Called"] = "The Church Called";
                self::$allMensagges[$leng]["has having the next rectors in his history"] = "has having the next rectors in his history";
                self::$allMensagges[$leng]["Add Relation"] = "Add Relation";
                self::$allMensagges[$leng]["Go To Rector Menu"] = "Go To Rector Menu";
                self::$allMensagges[$leng]["Go To Church Menu"] = "Go To Church Menu";
                self::$allMensagges[$leng]["No Rectors in this Church"] = "No Rectors in this Church";
                self::$allMensagges[$leng]["Lastname Rector"] = "Lastname Rector";
                self::$allMensagges[$leng]["Actual Church"] = "Actual Church";
                self::$allMensagges[$leng]["Rector Table"] = "Rector Table";
                self::$allMensagges[$leng]["Status"] = "Status";
                self::$allMensagges[$leng]["Position"] = "Position";
                self::$allMensagges[$leng]["Insert City"] = "Insert City";
                self::$allMensagges[$leng]["Insert New City"] = "Insert New City";
                self::$allMensagges[$leng]["State"] = "State";
                self::$allMensagges[$leng]["Insert State"] = "Insert State";
                self::$allMensagges[$leng]["Insert New State"] = "Insert New State";
                self::$allMensagges[$leng]["ShortName"] = "ShortName";
                self::$allMensagges[$leng]["Contry"] = "Contry";
                self::$allMensagges[$leng]["Insert Dean"] = "Insert Dean";
                self::$allMensagges[$leng]["Insert New Dean"] = "Insert New Dean";
                self::$allMensagges[$leng]["Insert Vicar"] = "Insert Vicar";
                self::$allMensagges[$leng]["Insert New Vicar"] = "Insert New Vicar";
                self::$allMensagges[$leng]["Proof Talks"] = "Proof Talks";
                self::$allMensagges[$leng]["Not Father"] = "Not Father";
                self::$allMensagges[$leng]["Not Mother"] = "Not Mother";
                self::$allMensagges[$leng]["Person List"] = "Person List";
                self::$allMensagges[$leng]["Select One Person to Get Data"] = "Select One Person to Get Data";
                self::$allMensagges[$leng]["Isn't Here"] = "Isn't Here";
                self::$allMensagges[$leng]["Insert Rector"] = "Insert Rector";
                self::$allMensagges[$leng]["Change Rector"] = "Change Rector";
                self::$allMensagges[$leng]["Look Rector"] = "Look Rector";
                self::$allMensagges[$leng]["About The Rector"] = "About The Rector";
                self::$allMensagges[$leng]["About Actual State"] = "About Actual State";
                self::$allMensagges[$leng]["Last/Actual Church"] = "Last/Actual Church";
                self::$allMensagges[$leng]["Active"] = "Active";
                self::$allMensagges[$leng]["Innactive"] = "Innactive";
                self::$allMensagges[$leng]["The Rector Called"] = "The Rector Called";
                self::$allMensagges[$leng]["has having in the next church in her history"] = "has having in the next church in her history";
                self::$allMensagges[$leng]["Insert Office Civil Registry"] = "Insert Office Civil Registry";
                self::$allMensagges[$leng]["Config"] = "Config";
                self::$allMensagges[$leng]["Config User Account"] = "Config User Account";
                self::$allMensagges[$leng]["Language"] = "Language";
                self::$allMensagges[$leng]["Spanish"] = "Spanish";
                self::$allMensagges[$leng]["English"] = "English";
                self::$allMensagges[$leng]["Successful Change"] = "Successful Change";
                self::$allMensagges[$leng]["Communion Menu"] = "Communion Menu";
                self::$allMensagges[$leng]["Communion Table"] = "Communion Table";
                self::$allMensagges[$leng]["Communion Date"] = "Communion Date";
                self::$allMensagges[$leng]["Communion Book"] = "Communion Book";
                self::$allMensagges[$leng]["Communion Page"] = "Communion Page";
                self::$allMensagges[$leng]["Insert Communion"] = "Insert Communion";
                self::$allMensagges[$leng]["Communion Number"] = "Communion Number";
                self::$allMensagges[$leng]["Look Communion"] = "Look Communion";
                self::$allMensagges[$leng]["Update Communion"] = "Update Communion";
                self::$allMensagges[$leng]["Communion Cert"] = "Communion Cert";
                self::$allMensagges[$leng]["Copy Communion Cert"] = "Copy Comunión Cert";
                self::$allMensagges[$leng]["Confirmation Menu"] = "Confirmation Menu";
                self::$allMensagges[$leng]["Confirmation Table"] = "Confirmation Table";
                self::$allMensagges[$leng]["Confirmation Date"] = "Confirmation Date";
                self::$allMensagges[$leng]["Confirmation Book"] = "Confirmation Book";
                self::$allMensagges[$leng]["Confirmation Page"] = "Confirmation Page";
                self::$allMensagges[$leng]["Insert Confirmation"] = "Insert Confirmation";
                self::$allMensagges[$leng]["Confirmation Number"] = "Confirmation Number";
                self::$allMensagges[$leng]["Look Confirmation"] = "Look Confirmation";
                self::$allMensagges[$leng]["Update Confirmation"] = "Update Confirmation";
                self::$allMensagges[$leng]["Confirmation Cert"] = "Confirmation Cert";
                self::$allMensagges[$leng]["Copy Confirmation Cert"] = "Copy Confirmation Cert";
                self::$allMensagges[$leng]["Marriage Menu"] = "Marriage Menu";
                self::$allMensagges[$leng]["Marriage Table"] = "Marriage Table";
                self::$allMensagges[$leng]["Marriage Date"] = "Marriage Date";
                self::$allMensagges[$leng]["Marriage Book"] = "Marriage Book";
                self::$allMensagges[$leng]["Marriage Page"] = "Marriage Page";
                self::$allMensagges[$leng]["Insert Marriage"] = "Insert Marriage";
                self::$allMensagges[$leng]["Marriage Number"] = "Marriage Number";
                self::$allMensagges[$leng]["Look Marriage"] = "Look Marriage";
                self::$allMensagges[$leng]["Update Marriage"] = "Update Marriage";
                self::$allMensagges[$leng]["Fullname Boyfriend"] = "Fullname Boyfriend";
                self::$allMensagges[$leng]["Fullname Girlfriend"] = "Fullname Girlfriend";
                self::$allMensagges[$leng]["Lastname Boyfriend"] = "Lastname Boyfriend";
                self::$allMensagges[$leng]["Lastname Girlfriend"] = "Lastname Girlfriend";
                self::$allMensagges[$leng]["About The Boyfriend"] = "About The Boyfriend";
                self::$allMensagges[$leng]["About The Girlfriend"] = "About The Girlfriend";
                self::$allMensagges[$leng]["About The Witness"] = "About The Witness";
                self::$allMensagges[$leng]["Witness1"] = "Witness 1";
                self::$allMensagges[$leng]["Witness2"] = "Witness 2";
                self::$allMensagges[$leng]["of Girlfriend"] = "of Girlfriend";
                self::$allMensagges[$leng]["of Boyfriend"] = "of Boyfriend";
                self::$allMensagges[$leng]["Names of Boyfriend"] = "Names of Boyfriend";
                self::$allMensagges[$leng]["Names of Girlfriend"] = "Names of Girlfriend";
                self::$allMensagges[$leng]["Church Marriage"] = "Church Marriage";
                self::$allMensagges[$leng]["Church Process"] = "Church Process";
                self::$allMensagges[$leng]["Update Marriage"] = "Update Marriage";
                self::$allMensagges[$leng]["Marriage Constancy"] = "Marriage Constancy";
                self::$allMensagges[$leng]["Copy Marriage Cert"] = "Copy Marriage Cert";
                self::$allMensagges[$leng]["Marriage Notice"] = "Marriage Notice";
                self::$allMensagges[$leng]["Marriage Exhort"] = "Marriage Exhort";
                self::$allMensagges[$leng]["Marriage Traslation"] = "Marriage Traslation";
                self::$allMensagges[$leng]["Proof Menu"] = "Proof Menu";
                self::$allMensagges[$leng]["Proof Table"] = "Proof Table";
                self::$allMensagges[$leng]["Look Proof"] = "Look Proof";
                self::$allMensagges[$leng]["City Address"] = "City Address";
                self::$allMensagges[$leng]["About The Godfather"] = "About The Godfather";
                self::$allMensagges[$leng]["About The Godmother"] = "About The Godmother";
                self::$allMensagges[$leng]["Change Proof"] = "Change Proof";
                self::$allMensagges[$leng]["Insert Proof"] = "Insert Proof";
                self::$allMensagges[$leng]["Defuntion"] = "Defuntion";
                self::$allMensagges[$leng]["Defuntion Table"] = "Defuntion Table";
                self::$allMensagges[$leng]["Fullname"] = "Fullname";
                self::$allMensagges[$leng]["Lastname"] = "Lastname";
                self::$allMensagges[$leng]["Defuntion Date"] = "Defuntion Date";
                self::$allMensagges[$leng]["of Owner"] = "of Owner";
                self::$allMensagges[$leng]["Names of Owner"] = "Names of Owner";
                self::$allMensagges[$leng]["Defuntion Menu"] = "Defuntion Menu";
                self::$allMensagges[$leng]["About The Person"] = "About The Person";
                self::$allMensagges[$leng]["Crypt"] = "Crypt";
                self::$allMensagges[$leng]["Have Crypt"] = "Have Crypt";
                self::$allMensagges[$leng]["Column"] = "Column";
                self::$allMensagges[$leng]["Row"] = "Row";
                self::$allMensagges[$leng]["Look Defuntion"] = "Look Defuntion";
                self::$allMensagges[$leng]["Change Defuntion"] = "Change Defuntion";
                self::$allMensagges[$leng]["Users"] = "Users";
                self::$allMensagges[$leng]["All"] = "All";
                self::$allMensagges[$leng]["User Menu"] = "User Menu";
                self::$allMensagges[$leng]["User Table"] = "User Table";
                self::$allMensagges[$leng]["Online"] = "Online";
                self::$allMensagges[$leng]["Offline"] = "Offline";
                self::$allMensagges[$leng]["Username"] = "Username";
                self::$allMensagges[$leng]["Only Online"] = "Only Online";
                self::$allMensagges[$leng]["Select one Contact"] = "Select one Contact";
                self::$allMensagges[$leng]["Message whit User"] = "Message whit User";
                self::$allMensagges[$leng]["Send"] = "Send";
                self::$allMensagges[$leng]["Message To"] = "Message To";
                self::$allMensagges[$leng]["of maximum 150 characters"] = "of maximum 150 characters";
                self::$allMensagges[$leng]["User"] = "User";
                self::$allMensagges[$leng]["Password"] = "Password";
                self::$allMensagges[$leng]["Password Again"] = "Password Again";
                self::$allMensagges[$leng]["Change Baptism"] = "Change Baptism";
                self::$allMensagges[$leng]["Change Communion"] = "Change Communion";
                self::$allMensagges[$leng]["Change Confirmation"] = "Change Confirmation";
                self::$allMensagges[$leng]["Change Marriage"] = "Change Marriage";
                self::$allMensagges[$leng]["Insert Defuntion"] = "Insert Defuntion";
                self::$allMensagges[$leng]["Change Marriage"] = "Change Marriage";
                self::$allMensagges[$leng]["Notice Of Privacy"] = "Notice Of Privacy";
                self::$allMensagges[$leng]["Check Our Notice Of Privacy"] = "Check Our Notice Of Privacy";
                self::$allMensagges[$leng]["Update The"] = "Update The";
                self::$allMensagges[$leng]["Print Setup"] = "Print Setup";
                self::$allMensagges[$leng]["About The Crypt Structure"] = "About The Crypt Structure";
                self::$allMensagges[$leng]["Insert User"] = "Insert User";
                self::$allMensagges[$leng]["About The User"] = "About The User";
                self::$allMensagges[$leng]["No Messages"] = "No Messages";
                self::$allMensagges[$leng]["Envelope Church"] = "Envelope Church";
                self::$allMensagges[$leng]["About The Baptism Registry"] = "About The Baptism Registry";

                self::$actualLanguage = "es";
            }
        }
    }

    LanguageSupport::inicialize();
 ?>
