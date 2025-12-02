<?php
// app/Http/Controllers/MaterialController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    private $materials = [];
    private $storageFile = 'materials.json';

    public function __construct()
    {
        $this->loadMaterials();
    }

    private function loadMaterials()
    {
        if (Storage::exists($this->storageFile)) {
            $this->materials = json_decode(Storage::get($this->storageFile), true) ?? [];
        } else {
            // Бастапқы материалдар
            $this->materials = [
                [
                    'id' => 1,
                    'subject' => 'Программирование',
                    'files' => [
                        [
                            'id' => 1,
                            'name' => 'Лекция 1.pdf',
                            'size' => '2.4 MB',
                            'date' => '2024-12-01',
                            'type' => 'pdf',
                            'url' => '#'
                        ]
                    ]
                ],
                [
                    'id' => 2,
                    'subject' => 'Математика',
                    'files' => [
                        [
                            'id' => 2,
                            'name' => 'Конспект лекций.pdf',
                            'size' => '31 MB',
                            'date' => '2024-12-02',
                            'type' => 'pdf',
                            'url' => '#'
                        ]
                    ]
                ]
            ];
            $this->saveMaterials();
        }
    }

    private function saveMaterials()
    {
        Storage::put($this->storageFile, json_encode($this->materials, JSON_PRETTY_PRINT));
    }

    public function teacherIndex()
    {
        $this->loadMaterials(); // Әр жолы жаңартып алу
        return view('materials.index', ['materials' => $this->materials]);
    }

    public function index()
    {
        return $this->teacherIndex();
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'filename' => 'required|string|max:255',
            'filetype' => 'required|string',
            'file' => 'required|file|max:10240'
        ]);

        try {
            // Материалдарды қайта жүктеу
            $this->loadMaterials();

            // Жаңа материал ID-сы
            $newMaterialId = count($this->materials) > 0 ? max(array_column($this->materials, 'id')) + 1 : 1;
            
            // Файл ID-сы
            $newFileId = 1;
            foreach ($this->materials as $material) {
                foreach ($material['files'] as $file) {
                    if ($file['id'] >= $newFileId) {
                        $newFileId = $file['id'] + 1;
                    }
                }
            }

            // Файлды сақтау
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $fileSize = round($file->getSize() / 1024 / 1024, 1) . ' MB';

            // Пән бойынша материалды табу
            $existingSubject = null;
            foreach ($this->materials as &$material) {
                if ($material['subject'] === $request->subject) {
                    $existingSubject = &$material;
                    break;
                }
            }

            if ($existingSubject) {
                // Пән бар, файл қосу
                $existingSubject['files'][] = [
                    'id' => $newFileId,
                    'name' => $request->filename . '.' . $request->filetype,
                    'size' => $fileSize,
                    'date' => date('Y-m-d'),
                    'type' => $request->filetype,
                    'url' => Storage::url($filePath)
                ];
            } else {
                // Жаңа пән қосу
                $this->materials[] = [
                    'id' => $newMaterialId,
                    'subject' => $request->subject,
                    'files' => [
                        [
                            'id' => $newFileId,
                            'name' => $request->filename . '.' . $request->filetype,
                            'size' => $fileSize,
                            'date' => date('Y-m-d'),
                            'type' => $request->filetype,
                            'url' => Storage::url($filePath)
                        ]
                    ]
                ];
            }

            $this->saveMaterials();

            return redirect()->route('teacher.materials')->with('success', 'Материал сәтті қосылды!');

        } catch (\Exception $e) {
            return redirect()->route('teacher.materials')->with('error', 'Қате орын алды: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->loadMaterials();
            
            // Материалды іздеу және жою
            $this->materials = array_filter($this->materials, function($material) use ($id) {
                return $material['id'] != $id;
            });

            // Индекстерді қайта реттеу
            $this->materials = array_values($this->materials);
            $this->saveMaterials();

            return redirect()->route('teacher.materials')->with('success', 'Материал сәтті жойылды!');

        } catch (\Exception $e) {
            return redirect()->route('teacher.materials')->with('error', 'Қате орын алды: ' . $e->getMessage());
        }
    }

    public function destroyFile($materialId, $fileId)
    {
        try {
            $this->loadMaterials();
            
            foreach ($this->materials as &$material) {
                if ($material['id'] == $materialId) {
                    $material['files'] = array_filter($material['files'], function($file) use ($fileId) {
                        return $file['id'] != $fileId;
                    });
                    $material['files'] = array_values($material['files']);
                    
                    // Егер пәнде файл қалмаса, пәнді де жою
                    if (empty($material['files'])) {
                        $this->materials = array_filter($this->materials, function($mat) use ($materialId) {
                            return $mat['id'] != $materialId;
                        });
                        $this->materials = array_values($this->materials);
                    }
                    break;
                }
            }

            $this->saveMaterials();
            return redirect()->route('teacher.materials')->with('success', 'Файл сәтті жойылды!');

        } catch (\Exception $e) {
            return redirect()->route('teacher.materials')->with('error', 'Қате орын алды: ' . $e->getMessage());
        }
    }
}