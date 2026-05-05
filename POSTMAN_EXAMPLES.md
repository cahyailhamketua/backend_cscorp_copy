# Postman API Examples

## 1. GET All Structurals (dengan Skills)

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/structurals`

**Response:**
```json
[
    {
        "id": 1,
        "nama": "John Doe",
        "jabatan": "CEO",
        "image": "structurals/abc123.jpeg",
        "deskripsi": "Deskripsi lengkap tentang John Doe dan pengalamannya di industri",
        "created_at": "2025-12-22T13:16:05.000000Z",
        "updated_at": "2025-12-22T13:16:05.000000Z",
        "skills": [
            {
                "id": 1,
                "structural_id": 1,
                "pengalaman": "Event Planning & Management",
                "created_at": "2025-12-22T13:20:00.000000Z",
                "updated_at": "2025-12-22T13:20:00.000000Z"
            },
            {
                "id": 2,
                "structural_id": 1,
                "pengalaman": "Team Leadership",
                "created_at": "2025-12-22T13:20:05.000000Z",
                "updated_at": "2025-12-22T13:20:05.000000Z"
            },
            {
                "id": 3,
                "structural_id": 1,
                "pengalaman": "Budget Management",
                "created_at": "2025-12-22T13:20:10.000000Z",
                "updated_at": "2025-12-22T13:20:10.000000Z"
            }
        ]
    }
]
```

---

## 2. GET Specific Structural by ID (dengan Skills)

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/structurals/1`

**Response:**
```json
{
    "id": 1,
    "nama": "John Doe",
    "jabatan": "CEO",
    "image": "structurals/abc123.jpeg",
    "deskripsi": "Deskripsi lengkap tentang John Doe dan pengalamannya di industri",
    "created_at": "2025-12-22T13:16:05.000000Z",
    "updated_at": "2025-12-22T13:16:05.000000Z",
    "skills": [
        {
            "id": 1,
            "structural_id": 1,
            "pengalaman": "Event Planning & Management",
            "created_at": "2025-12-22T13:20:00.000000Z",
            "updated_at": "2025-12-22T13:20:00.000000Z"
        },
        {
            "id": 2,
            "structural_id": 1,
            "pengalaman": "Team Leadership",
            "created_at": "2025-12-22T13:20:05.000000Z",
            "updated_at": "2025-12-22T13:20:05.000000Z"
        },
        {
            "id": 3,
            "structural_id": 1,
            "pengalaman": "Budget Management",
            "created_at": "2025-12-22T13:20:10.000000Z",
            "updated_at": "2025-12-22T13:20:10.000000Z"
        }
    ]
}
```

---

## 3. GET All Events (dengan Images)

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/events`

**Response:**
```json
[
    {
        "id": 1,
        "judul": "Borobudur Marathon",
        "deskripsi": "42 km marathon di area Borobudur",
        "tanggal": "2025-12-22",
        "client": "Cahya Ilham",
        "created_at": "2025-12-22T12:40:13.000000Z",
        "updated_at": "2025-12-22T12:40:13.000000Z",
        "images": [
            {
                "id": 1,
                "event_id": 1,
                "image": "events/01KD3163Y6DQ5ATBT3ESHZV76F.jpeg",
                "image_url": "https://cscorp.bgeodev.cloud/storage/events/01KD3163Y6DQ5ATBT3ESHZV76F.jpeg",
                "created_at": "2025-12-22T12:40:13.000000Z",
                "updated_at": "2025-12-22T12:40:13.000000Z"
            }
        ]
    }
]
```

---

## 4. GET All Productions (dengan Images)

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/productions`

**Response:**
```json
[
    {
        "id": 1,
        "judul": "Product Launch 2025",
        "deskripsi": "Peluncuran produk terbaru tahun 2025",
        "tanggal": "2025-12-22",
        "client": "Tech Company Inc",
        "created_at": "2025-12-22T12:00:00.000000Z",
        "updated_at": "2025-12-22T12:00:00.000000Z",
        "images": [
            {
                "id": 1,
                "production_id": 1,
                "image": "productions/01KD2Z488KR69SQB6AVB1RJAGZ.jpeg",
                "image_url": "https://cscorp.bgeodev.cloud/storage/productions/01KD2Z488KR69SQB6AVB1RJAGZ.jpeg",
                "created_at": "2025-12-22T12:00:00.000000Z",
                "updated_at": "2025-12-22T12:00:00.000000Z"
            }
        ]
    }
]
```

---

## 5. GET All Clients

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/clients`

**Response:**
```json
[
    {
        "id": 1,
        "nama": "PT. ABC Company",
        "email": "contact@abc.com",
        "nomor_telepon": "081234567890",
        "alamat": "Jakarta, Indonesia",
        "created_at": "2025-12-22T10:00:00.000000Z",
        "updated_at": "2025-12-22T10:00:00.000000Z"
    }
]
```

---

## 6. GET All Contacts

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/contacs`

**Response:**
```json
[
    {
        "id": 1,
        "nama": "Customer Service",
        "nomor_telepon": "081234567890",
        "email": "cs@company.com",
        "created_at": "2025-12-22T10:00:00.000000Z",
        "updated_at": "2025-12-22T10:00:00.000000Z"
    }
]
```

---

## 7. GET All Locations

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/locations`

**Response:**
```json
[
    {
        "id": 1,
        "nama": "Jakarta Office",
        "alamat": "Jl. Sudirman No. 1",
        "maps": "https://maps.google.com/...",
        "url_maps": "https://maps.app.goo.gl/...",
        "created_at": "2025-12-22T10:00:00.000000Z",
        "updated_at": "2025-12-22T10:00:00.000000Z"
    }
]
```

---

## 8. GET All Sosmeds

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/sosmeds`

**Response:**
```json
[
    {
        "id": 1,
        "sosmed_type": "instagram",
        "url": "https://instagram.com/cscorp",
        "created_at": "2025-12-22T10:00:00.000000Z",
        "updated_at": "2025-12-22T10:00:00.000000Z"
    }
]
```

---

## 9. GET All Visions

**Method:** GET  
**URL:** `https://cscorp.bgeodev.cloud/api/visions`

**Response:**
```json
[
    {
        "id": 1,
        "judul": "Visi Kami",
        "deskripsi": "Menjadi perusahaan event dan production terdepan di Asia Tenggara",
        "created_at": "2025-12-22T10:00:00.000000Z",
        "updated_at": "2025-12-22T10:00:00.000000Z"
    }
]
```

---

## Frontend Usage Example (JavaScript)

### Get Structurals dengan Skills

```javascript
fetch('https://cscorp.bgeodev.cloud/api/structurals')
  .then(res => res.json())
  .then(data => {
    data.forEach(structural => {
      console.log(`${structural.nama} - ${structural.jabatan}`);
      structural.skills.forEach(skill => {
        console.log(`  - ${skill.pengalaman}`);
      });
    });
  });
```

### Get Events dengan Images

```javascript
fetch('https://cscorp.bgeodev.cloud/api/events')
  .then(res => res.json())
  .then(events => {
    events.forEach(event => {
      console.log(event.judul);
      event.images.forEach(img => {
        // Gunakan image_url untuk menampilkan gambar
        console.log(`Image: ${img.image_url}`);
      });
    });
  });
```

### Get Productions dengan Images

```javascript
fetch('https://cscorp.bgeodev.cloud/api/productions')
  .then(res => res.json())
  .then(productions => {
    productions.forEach(prod => {
      console.log(prod.judul);
      prod.images.forEach(img => {
        // Gunakan image_url untuk menampilkan gambar
        console.log(`Image: ${img.image_url}`);
      });
    });
  });
```

---

## Frontend Usage Example (React)

```jsx
import { useEffect, useState } from 'react';

function StructuralsPage() {
  const [structurals, setStructurals] = useState([]);

  useEffect(() => {
    fetch('https://cscorp.bgeodev.cloud/api/structurals')
      .then(res => res.json())
      .then(data => setStructurals(data));
  }, []);

  return (
    <div>
      {structurals.map(structural => (
        <div key={structural.id}>
          <img src={`https://cscorp.bgeodev.cloud/storage/${structural.image}`} />
          <h2>{structural.nama}</h2>
          <p>{structural.jabatan}</p>
          <p>{structural.deskripsi}</p>
          <h3>Pengalaman:</h3>
          <ul>
            {structural.skills.map(skill => (
              <li key={skill.id}>{skill.pengalaman}</li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
}

export default StructuralsPage;
```

---

## Frontend Usage Example (Vue.js)

```vue
<template>
  <div>
    <div v-for="structural in structurals" :key="structural.id">
      <img :src="`https://cscorp.bgeodev.cloud/storage/${structural.image}`" />
      <h2>{{ structural.nama }}</h2>
      <p>{{ structural.jabatan }}</p>
      <p>{{ structural.deskripsi }}</p>
      <h3>Pengalaman:</h3>
      <ul>
        <li v-for="skill in structural.skills" :key="skill.id">
          {{ skill.pengalaman }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      structurals: []
    };
  },
  mounted() {
    fetch('https://cscorp.bgeodev.cloud/api/structurals')
      .then(res => res.json())
      .then(data => this.structurals = data);
  }
};
</script>
```
