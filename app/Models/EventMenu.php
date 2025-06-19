<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMenu extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'dish_category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function dishCategory()
    {
        return $this->belongsTo(DishCategory::class);
    }

    public function eventPackages()
    {
        return $this->belongsToMany(EventPackage::class, 'event_package_menus');
    }

    public function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'dish_category_id' => 'required|uuid|exists:dish_categories,id',
        ];
    }

    public function validationMessages()
    {
        return [
            'name.required' => 'Nama menu harus diisi.',
            'name.string' => 'Nama menu harus berupa teks.',
            'name.max' => 'Nama menu maksimal 255 karakter.',

            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',

            'image.string' => 'Path gambar harus berupa teks.',
            'image.max' => 'Path gambar maksimal 255 karakter.',

            'dish_category_id.required' => 'Kategori hidangan harus diisi.',
            'dish_category_id.uuid' => 'ID kategori hidangan harus berupa UUID.',
            'dish_category_id.exists' => 'Kategori hidangan tidak ditemukan.',
        ];
    }

    public function relations()
    {
        return [];
    }
} 