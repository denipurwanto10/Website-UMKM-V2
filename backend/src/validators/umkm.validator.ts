import { z } from 'zod';

// Port validasi Umkm::store (9 field required) + Umkm::update.
// Link marketplace (whatsapp/blibli/...) dibangun di service dari username
// mentah — field di sini menerima nilai mentah/URL, bukan URL jadi.
const base = z.object({
  username: z.string().min(1, 'Username wajib diisi'),
  nama_usaha: z.string().min(1, 'Nama usaha wajib diisi'),
  nama_merek_produk: z.string().min(1, 'Nama merek produk wajib diisi'),
  kategori_produk: z.string().min(1, 'Kategori produk wajib diisi'),
  jalan: z.string().min(1, 'Jalan wajib diisi'),
  desa_kelurahan: z.string().min(1, 'Desa/kelurahan wajib diisi'),
  kecamatan: z.string().min(1, 'Kecamatan wajib diisi'),
  jenis_usaha: z.string().min(1, 'Jenis usaha wajib diisi'),
  pendapatan: z.string().min(1, 'Pendapatan wajib diisi'),
  nib: z.string().nullish(),
  pirt: z.string().nullish(),
  bpom: z.string().nullish(),
  halal: z.string().nullish(),
  haki: z.string().nullish(),
  lainnya: z.string().nullish(),
  online: z.string().nullish(),
  offline: z.string().nullish(),
  agen_reseller: z.string().nullish(),
  deskripsi_produk: z.string().nullish(),
  status: z.enum(['menunggu', 'disetujui', 'ditolak']).optional(),
  catatan: z.string().nullish(),
  whatsapp: z.string().nullish(),
  blibli: z.string().nullish(),
  lazada: z.string().nullish(),
  shopee: z.string().nullish(),
  tokopedia: z.string().nullish(),
  facebook: z.string().nullish(),
  instagram: z.string().nullish(),
  tiktok: z.string().nullish(),
  twitter: z.string().nullish(),
});

export const createUmkmSchema = base;
export const updateUmkmSchema = base.partial().omit({ username: true });
