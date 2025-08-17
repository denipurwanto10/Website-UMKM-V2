
const express = require('express');
const router = express.Router();

const bcrypt = require('bcryptjs');
const cors = require('cors');
const mysql = require('mysql2');
const jwt = require('jsonwebtoken');

const app = express(); 
const port = 3000;
const SECRET_KEY = 'secretkey123'; // Ganti dengan secret key yang aman

// Middleware
app.use(cors());
app.use(express.json());

// Koneksi ke Database
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',  // Ubah jika menggunakan password MySQL
  database: 'skripsi',  // Nama database Anda
});

// Middleware Verifikasi Token
function verifyToken(req, res, next) {
    const token = req.headers['authorization'];
    if (!token) {
        return res.status(403).json({ message: 'No token provided' });
    }

    jwt.verify(token.split(' ')[1], SECRET_KEY, (err, decoded) => {
        if (err) {
            return res.status(401).json({ message: 'Failed to authenticate token' });
        }
        req.user = decoded;
        next();
    });
}

// ==================== TABLE USERS ============================

// POST Login User
//query aman
app.post('/api/login', async (req, res) => {
  try {
      const { username, password } = req.body;

      // Validasi format username
      const validUsername = /^[a-zA-Z0-9_.-]+$/;
      if (!validUsername.test(username)) {
          return res.status(403).json({ success: false, message: 'Format username tidak valid!' });
      }

      // Cek apakah user ada
      const [results] = await pool.promise().query(
  'SELECT * FROM users WHERE BINARY username = ?', 
  [username]
);
      if (results.length === 0) {
          return res.status(404).json({ success: false, message: 'User tidak ditemukan!' });
      }

      const user = results[0];

      // Bandingkan password
      const isMatch = await bcrypt.compare(password, user.password);
      if (!isMatch) {
          return res.status(401).json({ success: false, message: 'Username atau password salah!' });
      }

      // Buat JWT
      const token = jwt.sign({ username: user.username }, SECRET_KEY, { expiresIn: '1h' });

      res.json({ success: true, token, user });

  } catch (error) {
      console.error('Login error:', error);
      res.status(500).json({ success: false, message: 'Terjadi kesalahan server!' });
  }
});

//query tidak aman
// app.post('/api/login', async (req, res) => {
//   try {
//     const { username, password } = req.body;

//     // ✅ Query dengan SQL Injection sengaja dibiarkan rentan
//     const query = `SELECT * FROM users WHERE username = '${username}'`;
//     const [results] = await pool.promise().query(query); // ⚠️ Rentan SQL Injection!

//     if (results.length === 0) {
//       return res.status(404).json({ success: false, message: 'User tidak ditemukan!' });
//     }

//     const user = results[0];

//     // 🔓 Deteksi SEMUA jenis SQL Injection yang berhasil
//     const isInjectionAttempt = 
//       // Cek karakter berbahaya
//       /(['"\\=]|(\bOR\b)|(\bAND\b)|(\bUNION\b)|(\bSELECT\b)|(\bDROP\b)|(\bDELETE\b)|(--)|(\/\*))/i.test(username) ||
//       // Cek apakah hasil query TIDAK sama dengan username asli (artinya WHERE clause di-bypass)
//       results.some(u => u.username !== username.replace(/['"\\]/g, '').trim());

//     if (isInjectionAttempt) {
//       // ✅ Bypass password jika ada tanda SQL Injection berhasil
//       const token = jwt.sign({ username: user.username }, SECRET_KEY, { expiresIn: '1h' });
//       return res.json({
//         success: true,
//         token,
//         user,
//         message: 'Login berhasil (via SQL Injection - untuk pengujian)',
//       });
//     }

//     // 🔐 Jika tidak ada injection, cek password
//     const isMatch = await bcrypt.compare(password, user.password);
//     if (!isMatch) {
//       return res.status(401).json({ success: false, message: 'Password salah!' });
//     }

//     // Login normal
//     const token = jwt.sign({ username: user.username }, SECRET_KEY, { expiresIn: '1h' });
//     res.json({ success: true, token, user });

//   } catch (error) {
//     console.error('Login error:', error);
//     res.status(500).json({ success: false, message: 'Terjadi kesalahan server!' });
//   }
// });




// GET Profil User yang Sedang Login
app.get('/api/profile', verifyToken, (req, res) => {
    res.json({
        success: true,
        user: {
            username: req.user.username,
            fullname: req.user.fullname,
            photo: req.user.photo
        }
    });
});

// GET Semua Users
app.get('/api/users', (req, res) => {
  pool.query('SELECT * FROM users', (err, results) => {
    if (err) {
      console.error('Error fetching users:', err);
      return res.status(500).json({ error: 'Failed to fetch users' });
    }
    res.json(results);
  });
});

// GET Semua Username dari Users
//query tidak aman
// app.get('/api/users/usernames', (req, res) => {
  
//   // Menjalankan query SQL untuk mengambil data pengguna dari tabel 'users'
//   pool.query('SELECT username, fullname, usertype, nomor_hp, email, password, confpassword, photo FROM users', (err, results) => {
    
//     // Jika terjadi error saat menjalankan query, log error dan kirimkan response status 500 (Internal Server Error)
//     if (err) {
//       console.error('Error fetching user details:', err);  // Menampilkan error di console jika ada masalah
//       return res.status(500).json({ error: 'Failed to fetch user details' });  // Mengirimkan response JSON dengan error
//     }
    
//     // Jika query berhasil, kirimkan hasil query (data pengguna) dalam format JSON ke klien
//     res.json(results);  // Hasil query dikirimkan ke client dalam bentuk JSON
//   });
// });


//query aman
app.get('/api/users/usernames', (req, res) => {
  const { username } = req.query; // Mengambil parameter username dari query string

  // Periksa apakah parameter username ada
  if (!username) {
    return res.status(400).json({ error: 'Username parameter is required' });
  }

  // Validasi input untuk memastikan tidak ada karakter berbahaya
  const isValidUsername = /^[a-zA-Z0-9_]+$/.test(username); // Hanya memperbolehkan huruf, angka, dan underscore
  if (!isValidUsername) {
    return res.status(403).json({ error: 'Illegal access' }); // Mengembalikan error jika input tidak valid
  }

  // Gunakan prepared statement dengan tanda tanya (?) untuk mencegah SQL injection
  const query = 'SELECT * FROM users WHERE username = ?';
  
  // Menjalankan query dengan parameter username
  pool.query(query, [username], (err, results) => {
    if (err) {
      console.error('Error fetching user details:', err);
      return res.status(500).json({ error: 'Failed to fetch user details' });
    }

    // Jika username ditemukan, hasilnya akan dikembalikan
    if (results.length === 0) {
      return res.status(404).json({ message: 'Username not found' });
    }

    res.json(results[0]); // Mengembalikan hasil user pertama yang ditemukan
  });
});



// GET User Berdasarkan Username
app.get('/api/users/:username', (req, res) => {
  const { username } = req.params;
  pool.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err) {
      console.error('Error fetching user:', err);
      return res.status(500).json({ error: 'Failed to fetch user' });
    }
    if (results.length > 0) {
      res.json(results[0]);
    } else {
      res.status(404).json({ error: 'User not found' });
    }
  });
});

// POST Create User
app.post('/api/users', (req, res) => {
  const {
    username,
    password,
    confpassword,
    fullname,
    usertype,
    nomor_hp,
    email,
    photo
  } = req.body;

  if (!username || !password || !confpassword) {
    return res.status(400).json({ error: 'Username, Password, and Confirm Password are required' });
  }

  if (password !== confpassword) {
    return res.status(400).json({ error: 'Password and Confirm Password do not match' });
  }

  pool.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err) {
      console.error('Error checking username:', err);
      return res.status(500).json({ error: 'Failed to check username' });
    }
    if (results.length > 0) {
      return res.status(400).json({ error: 'Username is already taken' });
    }

    const saltRounds = 10;
    bcrypt.hash(password, saltRounds, (err, hashedPassword) => {
      if (err) {
        console.error('Error hashing password:', err);
        return res.status(500).json({ error: 'Failed to hash password' });
      }

      const sql = 'INSERT INTO users (username, fullname, usertype, nomor_hp, email, password, photo) VALUES (?, ?, ?, ?, ?, ?, ?)';
      const values = [
        username,
        fullname || '',
        usertype || '',
        nomor_hp || '',
        email || '',
        hashedPassword,
        photo || 'default.png'
      ];

      pool.query(sql, values, (err, result) => {
        if (err) {
          console.error('Error inserting user:', err);
          return res.status(500).json({ error: 'Failed to create user' });
        }
        res.status(201).json({ success: true, message: 'User created successfully' });
      });
    });
  });
});

// POST Register User
app.post('/api/register', (req, res) => {
  const {
    username,
    password,
    confpassword,
    fullname,
    nomor_hp,
    email,
    photo
  } = req.body;

  if (!username || !password || !confpassword) {
    return res.status(400).json({ error: 'Username, Password, and Confirm Password are required' });
  }

  if (password !== confpassword) {
    return res.status(400).json({ error: 'Password and Confirm Password do not match' });
  }

  pool.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err) {
      console.error('Error checking username:', err);
      return res.status(500).json({ error: 'Failed to check username' });
    }
    if (results.length > 0) {
      return res.status(400).json({ error: 'Username is already taken' });
    }

    const saltRounds = 10;
    bcrypt.hash(password, saltRounds, (err, hashedPassword) => {
      if (err) {
        console.error('Error hashing password:', err);
        return res.status(500).json({ error: 'Failed to hash password' });
      }

      const sql = 'INSERT INTO users (username, fullname, usertype, nomor_hp, email, password, photo) VALUES (?, ?, ?, ?, ?, ?, ?)';
      const values = [
        username,
        fullname || '',
        'Owner',  // Default usertype sebagai Owner
        nomor_hp || '',
        email || '',
        hashedPassword,
        photo || 'default.png'
      ];

      pool.query(sql, values, (err, result) => {
        if (err) {
          console.error('Error inserting user:', err);
          return res.status(500).json({ error: 'Failed to create user' });
        }
        res.status(201).json({ success: true, message: 'User registered successfully' });
      });
    });
  });
});

// PUT Update User
app.put('/api/users/:username', (req, res) => {
  const { username } = req.params;
  const { fullname, usertype, nomor_hp, email, password, photo } = req.body;

  pool.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err) {
      console.error('Error checking user:', err);
      return res.status(500).json({ error: 'Failed to check user' });
    }

    if (results.length === 0) {
      return res.status(404).json({ error: 'User not found' });
    }

    if (password) {
      const saltRounds = 10;
      bcrypt.hash(password, saltRounds, (err, hashedPassword) => {
        if (err) {
          console.error('Error hashing password:', err);
          return res.status(500).json({ error: 'Failed to hash password' });
        }
        updateUser(hashedPassword);
      });
    } else {
      updateUser(results[0].password);
    }
  });

  function updateUser(hashedPassword) {
    const sql = `
      UPDATE users SET 
      fullname = ?, 
      usertype = ?, 
      nomor_hp = ?, 
      email = ?, 
      password = ?, 
      photo = ?
      WHERE username = ?
    `;
    const values = [fullname, usertype, nomor_hp, email, hashedPassword, photo, username];

    pool.query(sql, values, (err, result) => {
      if (err) {
        console.error('Error updating user:', err);
        return res.status(500).json({ error: 'Failed to update user' });
      }
      res.json({ success: true, message: 'User updated successfully' });
    });
  }
});

// DELETE User Berdasarkan Username
app.delete('/api/users/:username', (req, res) => {
  const { username } = req.params;

  pool.query('DELETE FROM users WHERE username = ?', [username], (err, result) => {
    if (err) {
      console.error('Error deleting user:', err);
      return res.status(500).json({ error: 'Failed to delete user' });
    }
    res.json({ success: true, message: 'User deleted successfully' });
  });
});

// ==================== TABLE UMKM ============================

// GET Semua Data UMKM
app.get('/api/umkm', (req, res) => {
  const query = `
    SELECT umkm.*, users.fullname 
    FROM umkm
    JOIN users ON umkm.username = users.username`;

  pool.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching UMKM:', err);
      return res.status(500).json({ error: 'Failed to fetch UMKM data' });
    }
    res.json(results);
  });
});

// GET UMKM Berdasarkan ID
app.get('/api/umkm/:id', (req, res) => {
  const { id } = req.params;
  pool.query('SELECT * FROM umkm WHERE id = ?', [id], (err, results) => {
    if (err) {
      console.error('Error fetching umkm by ID:', err);
      return res.status(500).json({ error: 'Failed to fetch umkm' });
    }
    if (results.length > 0) {
      res.json(results[0]); // Return the single result
    } else {
      res.status(404).json({ error: 'umkm not found' }); // If no record found
    }
  });
});

app.get('/api/umkm/detail/:id', (req, res) => {
  const { id } = req.params;
  pool.query(
    `SELECT umkm.*, users.fullname 
     FROM umkm 
     JOIN users ON umkm.username = users.username 
     WHERE umkm.id = ?`, 
    [id], 
    (err, results) => {
      if (err) {
        console.error('Error fetching umkm by ID:', err);
        return res.status(500).json({ error: 'Failed to fetch umkm' });
      }
      if (results.length > 0) {
        res.json(results[0]); // Return the single result
      } else {
        res.status(404).json({ error: 'umkm not found' }); // If no record found
      }
    }
  );
});


// GET Data UMKM Berdasarkan Username
app.get('/api/umkm/user/:username', (req, res) => {
  const { username } = req.params;
  pool.query(`
    SELECT umkm.*, users.fullname 
    FROM umkm 
    JOIN users ON umkm.username = users.username
    WHERE umkm.username = ?`, [username], (err, results) => {
    if (err) {
      console.error('Error fetching UMKM by username:', err);
      return res.status(500).json({ error: 'Failed to fetch UMKM data' });
    }
    res.json(results);
  });
});


// GET Data UMKM dengan Status 'Menunggu'
app.get('/api/umkm/status/menunggu', (req, res) => {
  const query = `
    SELECT u.id, us.fullname, u.nama_usaha, u.nama_merek_produk, 
           u.kategori_produk, u.jenis_usaha, u.pendapatan, u.jalan, u.desa_kelurahan, u.kecamatan, 
           u.nib, u.pirt, u.bpom, u.halal, u.haki, u.lainnya, 
           u.online, u.offline, u.agen_reseller, u.deskripsi_produk, 
           u.photo, u.status, u.catatan, 
           u.whatsapp, u.blibli, u.lazada, u.shopee, u.tokopedia, 
           u.facebook, u.instagram, u.tiktok, u.twitter
    FROM umkm u
    JOIN users us ON u.username = us.username
    WHERE u.status = ?;
  `;

  pool.query(query, ['menunggu'], (err, results) => {
    if (err) {
      console.error('Error fetching UMKM with status "menunggu":', err);
      return res.status(500).json({ error: 'Failed to fetch UMKM data with status "menunggu"' });
    }
    res.json(results);
  });
});


// GET Data UMKM dengan Status 'Disetujui'
app.get('/api/umkm/status/disetujui', (req, res) => {
  const query = `
    SELECT u.id, us.fullname, u.nama_usaha, u.nama_merek_produk, 
           u.kategori_produk, u.jenis_usaha, u.pendapatan, u.jalan, u.desa_kelurahan, u.kecamatan, 
           u.nib, u.pirt, u.bpom, u.halal, u.haki, u.lainnya, 
           u.online, u.offline, u.agen_reseller, u.deskripsi_produk, 
           u.photo, u.status, u.catatan, 
           u.whatsapp, u.blibli, u.lazada, u.shopee, u.tokopedia, 
           u.facebook, u.instagram, u.tiktok, u.twitter
    FROM umkm u
    JOIN users us ON u.username = us.username
    WHERE u.status = ?;
  `;

  pool.query(query, ['disetujui'], (err, results) => {
    if (err) {
      console.error('Error fetching UMKM with status "disetujui":', err);
      return res.status(500).json({ error: 'Failed to fetch UMKM data with status "disetujui"' });
    }
    res.json(results);
  });
});


// GET Data UMKM dengan Status 'Ditolak'
app.get('/api/umkm/status/ditolak', (req, res) => {
  const query = `
     SELECT u.id, us.fullname, u.nama_usaha, u.nama_merek_produk, 
           u.kategori_produk, u.jenis_usaha, u.pendapatan, u.jalan, u.desa_kelurahan, u.kecamatan, 
           u.nib, u.pirt, u.bpom, u.halal, u.haki, u.lainnya, 
           u.online, u.offline, u.agen_reseller, u.deskripsi_produk, 
           u.photo, u.status, u.catatan, 
           u.whatsapp, u.blibli, u.lazada, u.shopee, u.tokopedia, 
           u.facebook, u.instagram, u.tiktok, u.twitter
    FROM umkm u
    JOIN users us ON u.username = us.username
    WHERE u.status = ?;
  `;

  pool.query(query, ['ditolak'], (err, results) => {
    if (err) {
      console.error('Error fetching UMKM with status "ditolak":', err);
      return res.status(500).json({ error: 'Failed to fetch UMKM data with status "ditolak"' });
    }
    res.json(results);
  });
});


app.get('/api/umkm/status/disetujui/count', (req, res) => {
  pool.query(`
    SELECT 
      kecamatan,
      desa_kelurahan,
      COUNT(*) AS total_desa_kelurahan,
      SUM(LOWER(jenis_usaha) = 'mikro') AS mikro,
      SUM(LOWER(jenis_usaha) = 'kecil') AS kecil,
      SUM(LOWER(jenis_usaha) = 'menengah') AS menengah
    FROM umkm 
    WHERE status = ?
    GROUP BY kecamatan, desa_kelurahan
    ORDER BY kecamatan, desa_kelurahan
  `, ['disetujui'], (err, results) => {
    if (err) {
      console.error('Error counting desa_kelurahan and jenis_usaha for UMKM with status "disetujui":', err);
      return res.status(500).json({ error: 'Failed to count data by kecamatan and jenis_usaha' });
    }

    res.json(results);
  });
});



// POST Create UMKM
app.post('/api/umkm', (req, res) => {
  const data = {
    username: req.body.username,
    nama_usaha: req.body.nama_usaha,
    nama_merek_produk: req.body.nama_merek_produk,
    kategori_produk: req.body.kategori_produk,
    jalan: req.body.jalan,
    desa_kelurahan: req.body.desa_kelurahan,
    kecamatan: req.body.kecamatan,
    jenis_usaha: req.body.jenis_usaha,
    pendapatan: req.body.pendapatan,
    nib: req.body.nib || null,
    pirt: req.body.pirt || null,
    bpom: req.body.bpom || null,
    halal: req.body.halal || null,
    haki: req.body.haki || null,
    lainnya: req.body.lainnya || null,
    online: req.body.online || false,
    offline: req.body.offline || false,
    agen_reseller: req.body.agen_reseller || false,
    deskripsi_produk: req.body.deskripsi_produk || '',
    photo: req.body.photo || 'default.png',
    status: req.body.status || 'menunggu',
    catatan: req.body.catatan || '-',
    whatsapp: req.body.whatsapp || null,
    blibli: req.body.blibli || null,
    lazada: req.body.lazada || null,
    shopee: req.body.shopee || null,
    tokopedia: req.body.tokopedia || null,
    facebook: req.body.facebook || null,
    instagram: req.body.instagram || null,
    tiktok: req.body.tiktok || null,
    twitter: req.body.twitter || null
  };

  // Validasi field wajib
  const requiredFields = ['username', 'nama_usaha', 'nama_merek_produk', 'kategori_produk', 'jalan', 'desa_kelurahan', 'kecamatan'];
  for (const field of requiredFields) {
    if (!data[field]) return res.status(400).json({ error: 'All required fields must be provided' });
  }

  // Cek username
  const checkQuery = 'SELECT * FROM umkm WHERE username = ? AND (status = "menunggu" OR status = "disetujui")';
  pool.query(checkQuery, [data.username], (err, result) => {
    if (err) return res.status(500).json({ error: 'Database query failed' });
    if (result.length > 0) return res.status(400).json({ error: 'Username sudah terdaftar' });

    // Query insert
    const sql = `INSERT INTO umkm (
      ${Object.keys(data).join(', ')}
    ) VALUES (
      ${Object.keys(data).map(() => '?').join(', ')}
    )`;

    pool.query(sql, Object.values(data), (err) => {
      if (err) return res.status(500).json({ error: 'Failed to create UMKM' });
      res.status(201).json({ success: true, message: 'UMKM created successfully' });
    });
  });
});



// PUT Update UMKM
app.put('/api/umkm/:id', (req, res) => {
  const { id } = req.params;

  const data = {
    username: req.body.username,
    nama_usaha: req.body.nama_usaha,
    nama_merek_produk: req.body.nama_merek_produk,
    kategori_produk: req.body.kategori_produk,
    jalan: req.body.jalan,
    desa_kelurahan: req.body.desa_kelurahan,
    kecamatan: req.body.kecamatan,
    jenis_usaha: req.body.jenis_usaha,
    pendapatan: req.body.pendapatan,
    nib: req.body.nib || null,
    pirt: req.body.pirt || null,
    bpom: req.body.bpom || null,
    halal: req.body.halal || null,
    haki: req.body.haki || null,
    lainnya: req.body.lainnya || null,
    online: req.body.online || false,
    offline: req.body.offline || false,
    agen_reseller: req.body.agen_reseller || false,
    deskripsi_produk: req.body.deskripsi_produk || '',
    photo: req.body.photo || 'default.png',
    status: req.body.status || 'menunggu',
    catatan: req.body.catatan || '-',
    whatsapp: req.body.whatsapp || null,
    blibli: req.body.blibli || null,
    lazada: req.body.lazada || null,
    shopee: req.body.shopee || null,
    tokopedia: req.body.tokopedia || null,
    facebook: req.body.facebook || null,
    instagram: req.body.instagram || null,
    tiktok: req.body.tiktok || null,
    twitter: req.body.twitter || null
  };

  const fields = Object.keys(data).map(key => `${key} = ?`).join(', ');
  const sql = `UPDATE umkm SET ${fields} WHERE id = ?`;
  const values = [...Object.values(data), id];

  pool.query(sql, values, (err, result) => {
    if (err) {
      console.error('Error updating UMKM:', err);
      return res.status(500).json({ error: 'Failed to update UMKM' });
    }

    if (result.affectedRows === 0) {
      return res.status(404).json({ error: 'UMKM not found' });
    }

    res.json({ success: true, message: 'UMKM updated successfully' });
  });
});




// DELETE UMKM Berdasarkan ID
app.delete('/api/umkm/:id', (req, res) => {
  const { id } = req.params;

  pool.query('DELETE FROM umkm WHERE id = ?', [id], (err, result) => {
    if (err) {
      console.error('Error deleting UMKM:', err);
      return res.status(500).json({ error: 'Failed to delete UMKM' });
    }
    
    if (result.affectedRows === 0) {
      return res.status(404).json({ error: 'UMKM not found' });
    }

    res.json({ success: true, message: 'UMKM deleted successfully' });
  });
});
app.get('/api/count-owners', (req, res) => {
  pool.query('SELECT COUNT(*) AS count FROM users WHERE usertype = "Owner"', (err, results) => {
    if (err) {
      console.error('Error counting owners:', err);
      return res.status(500).json({ error: 'Failed to count owners' });
    }
    res.json({ count: results[0].count });
  });
});
app.get('/api/count-admins', (req, res) => {
  pool.query('SELECT COUNT(*) AS count FROM users WHERE usertype = "Admin"', (err, results) => {
    if (err) {
      console.error('Error counting admins:', err);
      return res.status(500).json({ error: 'Failed to count admins' });
    }
    res.json({ count: results[0].count });
  });
});
app.get('/api/count-umkm-disetujui', (req, res) => {
  pool.query('SELECT COUNT(*) AS count FROM umkm WHERE status = "disetujui"', (err, results) => {
    if (err) {
      console.error('Error counting UMKM with status "disetujui":', err);
      return res.status(500).json({ error: 'Failed to count UMKM' });
    }
    res.json({ count: results[0].count });
  });
});

app.get('/api/umkm-per-kategori-disetujui', (req, res) => {
  const sql = `
    SELECT kategori_produk, COUNT(*) AS jumlah_umkm
    FROM umkm
    WHERE status = 'disetujui'
    GROUP BY kategori_produk
  `;

  pool.query(sql, (err, results) => {
    if (err) {
      console.error('Error counting UMKM with status "disetujui" per kategori:', err);
      return res.status(500).json({ error: 'Failed to count UMKM per kategori' });
    }
    res.json(results);
  });
});

// API untuk mendapatkan jumlah desa per kategori
// API untuk menghitung jumlah UMKM berdasarkan jenis_usaha
app.get('/api/jumlah-jenis-usaha', (req, res) => {
  const sql = `
    SELECT jenis_usaha, COUNT(*) AS jumlah
    FROM umkm
    WHERE jenis_usaha IN ('Mikro', 'Kecil', 'Menengah')
    GROUP BY jenis_usaha
  `;

  pool.query(sql, (err, results) => {
    if (err) {
      console.error('Error fetching data:', err);
      return res.status(500).json({ error: 'Gagal mengambil data' });
    }
    res.json(results);
  });
});

app.get('/api/jumlah-desa-per-kategori', (req, res) => {
  const sql = `
  SELECT kategori_produk, COUNT(DISTINCT desa_kelurahan) AS jumlah_desa
  FROM umkm
  GROUP BY kategori_produk
`;


  pool.query(sql, (err, results) => {
      if (err) {
          console.error('Error fetching data:', err);
          return res.status(500).json({ error: 'Failed to fetch data' });
      }
      res.json(results);
  });
});

app.get('/api/jumlah-desa-per-kecamatan', (req, res) => {
  const sql = `
      SELECT kecamatan, COUNT(DISTINCT desa_kelurahan) AS jumlah_desa
      FROM umkm
      GROUP BY kecamatan
  `;

  pool.query(sql, (err, results) => {
      if (err) {
          console.error('Error fetching data:', err);
          return res.status(500).json({ error: 'Failed to fetch data' });
      }
      res.json(results); // Mengirimkan hasil query dalam format JSON
  });
});

// ==================== TABLE PROMOSI ============================
// GET Semua Data Promosi
// GET Semua Data Promosi dengan status 'disetujui' pada tabel umkm
app.get('/api/promosi', (req, res) => {
  pool.query(`
    SELECT promosi.*, users.fullname 
    FROM promosi 
    JOIN umkm ON promosi.username = umkm.username
    JOIN users ON umkm.username = users.username
    WHERE umkm.status = 'disetujui'`, 
    (err, results) => {
    if (err) {
      console.error('Error fetching Promosi:', err);
      return res.status(500).json({ error: 'Failed to fetch Promosi data' });
    }
    res.json(results);
  });
});



// GET Promosi Berdasarkan ID
app.get('/api/promosi/:id', (req, res) => {
  const { id } = req.params;
  pool.query('SELECT * FROM promosi WHERE id = ?', [id], (err, results) => {
    if (err) {
      console.error('Error fetching Promosi by ID:', err);
      return res.status(500).json({ error: 'Failed to fetch Promosi' });
    }
    if (results.length > 0) {
      res.json(results[0]); // Return the single result
    } else {
      res.status(404).json({ error: 'Promosi not found' }); // If no record found
    }
  });
});

// GET Data Promosi Berdasarkan Username
app.get('/api/promosi/user/:username', (req, res) => {
  const { username } = req.params;
  pool.query('SELECT * FROM promosi WHERE username = ?', [username], (err, results) => {
    if (err) {
      console.error('Error fetching Promosi by username:', err);
      return res.status(500).json({ error: 'Failed to fetch Promosi data' });
    }
    if (results.length === 0) {
      return res.status(404).json({ error: 'No Promosi found for this user' });
    }
    res.json(results); // Return the results array
  });
});


//create promosi dengan cek duplikasi username
app.post('/api/promosi', (req, res) => {
  const { username } = req.body;
  if (!username) return res.status(400).json({ error: 'Username is required' });

  const query = (sql, params) => new Promise((resolve, reject) =>
    pool.query(sql, params, (err, result) => err ? reject(err) : resolve(result))
  );

  (async () => {
    try {
      const user = await query('SELECT * FROM users WHERE username = ?', [username]);
      if (user.length === 0) return res.status(404).json({ error: 'Username not found' });

      const umkm = await query('SELECT * FROM umkm WHERE username = ? AND status = "disetujui"', [username]);
      if (umkm.length === 0) return res.status(400).json({ error: 'No approved UMKM found for this username' });

      const promosi = await query('SELECT * FROM promosi WHERE username = ?', [username]);
      if (promosi.length > 0) return res.status(400).json({ error: 'Promosi for this username already exists' });

      const {
        fasilitasi_promosi = "",
        hambatan_memasarkan_produk = "",
        bantuan_dibutuhkan = "",
        berminat_bazar_ramadhan = "",
        berminat_pelatihan_online = ""
      } = req.body;

      const insertSql = `
        INSERT INTO promosi (
          username, fasilitasi_promosi, hambatan_memasarkan_produk,
          bantuan_dibutuhkan, berminat_bazar_ramadhan, berminat_pelatihan_online
        ) VALUES (?, ?, ?, ?, ?, ?)
      `;

      const values = [
        username,
        fasilitasi_promosi,
        hambatan_memasarkan_produk,
        bantuan_dibutuhkan,
        berminat_bazar_ramadhan,
        berminat_pelatihan_online
      ];

      const result = await query(insertSql, values);
      res.status(201).json({ success: true, message: 'Promosi created successfully', data: result });
    } catch (err) {
      console.error('Error creating Promosi:', err);
      res.status(500).json({ error: 'Server error', details: err.message });
    }
  })();
});

// Edit promosi berdasarkan id
app.put('/api/promosi/:id', (req, res) => {
  const { id } = req.params;
  const {
    fasilitasi_promosi,
    hambatan_memasarkan_produk,
    bantuan_dibutuhkan,
    berminat_bazar_ramadhan,
    berminat_pelatihan_online
  } = req.body;

  const query = (sql, params) => new Promise((resolve, reject) =>
    pool.query(sql, params, (err, result) => err ? reject(err) : resolve(result))
  );

  (async () => {
    try {
      const promoResult = await query('SELECT * FROM promosi WHERE id = ?', [id]);
      if (promoResult.length === 0) return res.status(404).json({ error: 'No Promosi found for this id' });

      const data = promoResult[0];

      const updateSql = `
        UPDATE promosi SET 
          fasilitasi_promosi = ?, 
          hambatan_memasarkan_produk = ?, 
          bantuan_dibutuhkan = ?, 
          berminat_bazar_ramadhan = ?, 
          berminat_pelatihan_online = ?
        WHERE id = ?
      `;

      const values = [
        fasilitasi_promosi ?? data.fasilitasi_promosi,
        hambatan_memasarkan_produk ?? data.hambatan_memasarkan_produk,
        bantuan_dibutuhkan ?? data.bantuan_dibutuhkan,
        berminat_bazar_ramadhan ?? data.berminat_bazar_ramadhan,
        berminat_pelatihan_online ?? data.berminat_pelatihan_online,
        id
      ];

      const updateResult = await query(updateSql, values);
      res.status(200).json({ success: true, message: 'Promosi updated successfully', data: updateResult });
    } catch (err) {
      console.error('Error updating Promosi:', err);
      res.status(500).json({ error: 'Failed to update Promosi', details: err.message });
    }
  })();
});

// Delete promosi by ID
app.delete('/api/promosi/:id', (req, res) => {
  const promosiId = req.params.id;

  // Cek apakah ID ada
  const checkPromosiQuery = 'SELECT * FROM promosi WHERE id = ?';
  pool.query(checkPromosiQuery, [promosiId], (checkErr, checkResult) => {
    if (checkErr) {
      console.error('Error checking Promosi ID:', checkErr);
      return res.status(500).json({ error: 'Server error while checking Promosi ID' });
    }

    // Jika data promosi tidak ditemukan
    if (checkResult.length === 0) {
      return res.status(404).json({ error: 'Promosi not found' });
    }

    // Query untuk menghapus data promosi
    const deleteQuery = 'DELETE FROM promosi WHERE id = ?';
    pool.query(deleteQuery, [promosiId], (deleteErr, deleteResult) => {
      if (deleteErr) {
        console.error('Error deleting Promosi:', deleteErr);
        return res.status(500).json({ error: 'Failed to delete Promosi', details: deleteErr.message });
      }

      res.status(200).json({ success: true, message: 'Promosi deleted successfully' });
    });
  });
});

//===============INDEX===========
app.get('/api/count-users', (req, res) => {
  pool.query('SELECT COUNT(*) AS count FROM users', (err, results) => {
    if (err) {
      console.error('Error counting users:', err);
      return res.status(500).json({ error: 'Failed to count users' });
    }
    res.json({ count: results[0].count });
  });
});

app.get('/api/count-umkm', (req, res) => {
  pool.query('SELECT COUNT(*) AS count FROM umkm', (err, results) => {
    if (err) {
      console.error('Error counting UMKM:', err);
      return res.status(500).json({ error: 'Failed to count UMKM' });
    }
    res.json({ count: results[0].count });
  });
});



// Server Listener
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
