<?php

if (!function_exists('uploadCapacitacionFile')) {
    /**
     * Sube archivos (PDFs o imágenes) para capacitaciones.
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file Archivo subido.
     * @param int $docenteId ID del docente.
     * @param string $capacitacionNombre Nombre de la capacitación para el archivo.
     * @return array Resultado con éxito/error y ruta del archivo.
     */
    function uploadCapacitacionFile($file, $docenteId, $capacitacionNombre = '')
    {
        // Debug inicial
        log_message('debug', 'uploadCapacitacionFile called with docenteId: ' . $docenteId);

        // Validar entrada
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            log_message('error', 'Invalid file or already moved');
            return ['success' => false, 'message' => 'Archivo no válido o ya procesado'];
        }

        // Configurar ruta: uploads/docenteId/capacitaciones/
        $uploadPath = ROOTPATH . 'public/uploads/' . $docenteId . '/capacitaciones/';
        log_message('debug', 'Upload path: ' . $uploadPath);

        // Crear directorio si no existe
        if (!is_dir($uploadPath)) {
            log_message('debug', 'Creating directory: ' . $uploadPath);
            if (!mkdir($uploadPath, 0755, true)) {
                log_message('error', 'Failed to create directory: ' . $uploadPath);
                return ['success' => false, 'message' => 'Error al crear el directorio de destino'];
            }
        }

        // Validar tipo de archivo (solo PDFs e imágenes)
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientExtension());

        log_message('debug', 'File extension: ' . $extension);

        if (!in_array($extension, $allowedTypes)) {
            log_message('error', 'Invalid file type: ' . $extension);
            return [
                'success' => false,
                'message' => 'Tipo de archivo no permitido. Solo se permiten: PDF, JPG, JPEG, PNG, GIF, WEBP'
            ];
        }

        // Validar tamaño (máximo 10MB)
        $maxSize = 10 * 1024 * 1024; // 10MB
        if ($file->getSize() > $maxSize) {
            log_message('error', 'File too large: ' . $file->getSize() . ' bytes');
            return [
                'success' => false,
                'message' => 'El archivo excede el tamaño máximo de 10MB'
            ];
        }

        try {
            // Generar nombre único para el archivo
            $timestamp = time();
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $capacitacionNombre);
            $fileName = !empty($safeName) ? "{$safeName}_{$timestamp}.{$extension}" : "capacitacion_{$timestamp}.{$extension}";

            log_message('debug', 'Generated filename: ' . $fileName);
            log_message('debug', 'Full path: ' . $uploadPath . $fileName);

            // Mover archivo directamente (sin redimensionar)
            if (!$file->move($uploadPath, $fileName)) {
                log_message('error', 'Failed to move file to: ' . $uploadPath . $fileName);
                return [
                    'success' => false,
                    'message' => 'Error al mover el archivo al directorio de destino'
                ];
            }

            // Verificar que el archivo se movió correctamente
            $fullPath = $uploadPath . $fileName;
            if (!file_exists($fullPath)) {
                log_message('error', 'File was not created at: ' . $fullPath);
                return [
                    'success' => false,
                    'message' => 'Error: El archivo no se guardó correctamente'
                ];
            }

            // Retornar ruta relativa
            $relativePath = "uploads/{$docenteId}/capacitaciones/{$fileName}";
            log_message('debug', 'File uploaded successfully - Relative path: ' . $relativePath);

            return [
                'success' => true,
                'path' => $relativePath,
                'filename' => $fileName,
                'message' => 'Archivo subido exitosamente'
            ];

        } catch (\Exception $e) {
            log_message('error', 'Exception uploading capacitacion file: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('getCapacitacionFile')) {
    /**
     * Obtiene la URL completa de un archivo de capacitación.
     *
     * @param string $filePath Ruta del archivo almacenada en BD.
     * @return string URL del archivo o archivo por defecto.
     */
    function getCapacitacionFile($filePath = null)
    {
        // Archivo por defecto
        $defaultFile = 'assets/images/default-document.png';

        // Verificar si la ruta está definida y no está vacía
        if (!empty($filePath)) {
            $fullPath = FCPATH . $filePath;

            // Verificar si el archivo existe
            if (file_exists($fullPath)) {
                return base_url($filePath);
            }
        }

        // Retornar archivo por defecto
        return base_url($defaultFile);
    }
}

if (!function_exists('deleteCapacitacionFile')) {
    /**
     * Elimina un archivo de capacitación del servidor.
     *
     * @param string $filePath Ruta del archivo a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    function deleteCapacitacionFile($filePath)
    {
        if (empty($filePath)) {
            return false;
        }

        $fullPath = FCPATH . $filePath;

        if (file_exists($fullPath)) {
            try {
                return unlink($fullPath);
            } catch (\Exception $e) {
                log_message('error', 'Error deleting capacitacion file: ' . $e->getMessage());
                return false;
            }
        }

        return false;
    }
}

if (!function_exists('deleteDocenteCapacitacionesFolder')) {
    /**
     * Elimina toda la carpeta de capacitaciones de un docente.
     *
     * @param int $docenteId ID del docente.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    function deleteDocenteCapacitacionesFolder($docenteId)
    {
        if (empty($docenteId)) {
            return false;
        }

        $folderPath = FCPATH . "uploads/{$docenteId}";

        if (is_dir($folderPath)) {
            try {
                return removeDirectory($folderPath);
            } catch (\Exception $e) {
                log_message('error', 'Error deleting docente folder: ' . $e->getMessage());
                return false;
            }
        }

        return true; // Si no existe, consideramos que está "eliminado"
    }
}

if (!function_exists('removeDirectory')) {
    /**
     * Elimina un directorio y todo su contenido recursivamente.
     *
     * @param string $dir Ruta del directorio a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($filePath)) {
                removeDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }

        return rmdir($dir);
    }
}

if (!function_exists('validateCapacitacionFile')) {
    /**
     * Valida un archivo antes de procesarlo.
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file Archivo a validar.
     * @return array Resultado de la validación.
     */
    function validateCapacitacionFile($file)
    {
        $errors = [];

        // Verificar si el archivo es válido
        if (!$file || !$file->isValid()) {
            $errors[] = 'El archivo no es válido';
        }

        if ($file->hasMoved()) {
            $errors[] = 'El archivo ya ha sido procesado';
        }

        // Validar extensión
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientExtension());

        if (!in_array($extension, $allowedTypes)) {
            $allowedStr = implode(', ', $allowedTypes);
            $errors[] = "Extensión no permitida. Permitidas: {$allowedStr}";
        }

        // Validar tamaño (máximo 10MB)
        $maxSize = 10 * 1024 * 1024;
        if ($file->getSize() > $maxSize) {
            $errors[] = "El archivo excede el tamaño máximo de 10MB";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}

if (!function_exists('getFileIcon')) {
    /**
     * Obtiene el icono CSS apropiado según la extensión del archivo.
     *
     * @param string $filePath Ruta del archivo.
     * @return string Clase CSS del icono.
     */
    function getFileIcon($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        $icons = [
            'pdf' => 'fas fa-file-pdf text-red-500',
            'jpg' => 'fas fa-file-image text-purple-500',
            'jpeg' => 'fas fa-file-image text-purple-500',
            'png' => 'fas fa-file-image text-purple-500',
            'gif' => 'fas fa-file-image text-purple-500',
            'webp' => 'fas fa-file-image text-purple-500'
        ];

        return $icons[$extension] ?? 'fas fa-file text-gray-400';
    }
}

if (!function_exists('uploadLibroFile')) {
    /**
     * Sube archivos (PDFs o imágenes) para libros.
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file Archivo subido.
     * @param int $docenteId ID del docente.
     * @param string $tipo Tipo de archivo: 'libro' o 'portada'.
     * @return array Resultado con éxito/error y ruta del archivo.
     */
    function uploadLibroFile($file, $docenteId, $tipo = 'libro')
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return ['success' => false, 'message' => 'Archivo no válido o ya procesado'];
        }
        $folder = $tipo === 'portada' ? 'portadas' : 'libros';
        $uploadPath = ROOTPATH . 'public/uploads/' . $docenteId . '/' . $folder . '/';
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                return ['success' => false, 'message' => 'Error al crear el directorio de destino'];
            }
        }
        $allowedTypes = $tipo === 'portada' ? ['jpg', 'jpeg', 'png', 'gif', 'webp'] : ['pdf'];
        $extension = strtolower($file->getClientExtension());
        if (!in_array($extension, $allowedTypes)) {
            return [
                'success' => false,
                'message' => $tipo === 'portada' ? 'Solo se permiten imágenes (JPG, PNG, GIF, WEBP)' : 'Solo se permite PDF para el libro'
            ];
        }
        $maxSize = $tipo === 'portada' ? 5 * 1024 * 1024 : 20 * 1024 * 1024; // 5MB portada, 20MB libro
        if ($file->getSize() > $maxSize) {
            return [
                'success' => false,
                'message' => $tipo === 'portada' ? 'La portada no debe exceder 5MB' : 'El archivo no debe exceder 20MB'
            ];
        }
        try {
            $timestamp = time();
            $fileName = $tipo . '_' . $timestamp . '.' . $extension;
            if (!$file->move($uploadPath, $fileName)) {
                return [
                    'success' => false,
                    'message' => 'Error al mover el archivo al directorio de destino'
                ];
            }
            $fullPath = $uploadPath . $fileName;
            if (!file_exists($fullPath)) {
                return [
                    'success' => false,
                    'message' => 'Error: El archivo no se guardó correctamente'
                ];
            }
            $relativePath = 'uploads/' . $docenteId . '/' . $folder . '/' . $fileName;
            return [
                'success' => true,
                'path' => $relativePath,
                'filename' => $fileName,
                'message' => 'Archivo subido exitosamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ];
        }
    }
}

if (!function_exists('deleteLibroFile')) {
    /**
     * Elimina un archivo de libro del servidor.
     * @param string $filePath Ruta del archivo a eliminar.
     * @return bool
     */
    function deleteLibroFile($filePath)
    {
        if (empty($filePath)) return false;
        $fullPath = FCPATH . $filePath;
        if (file_exists($fullPath)) {
            try {
                return unlink($fullPath);
            } catch (\Exception $e) {
                log_message('error', 'Error deleting libro file: ' . $e->getMessage());
                return false;
            }
        }
        return false;
    }
}

if (!function_exists('getLibroFile')) {
    /**
     * Obtiene la URL completa de un archivo de libro.
     * @param string $filePath Ruta del archivo almacenada en BD.
     * @return string URL del archivo o archivo por defecto.
     */
    function getLibroFile($filePath = null)
    {
        $defaultFile = 'assets/images/default-document.png';
        if (!empty($filePath)) {
            $fullPath = FCPATH . $filePath;
            if (file_exists($fullPath)) {
                return base_url($filePath);
            }
        }
        return base_url($defaultFile);
    }
}

?>