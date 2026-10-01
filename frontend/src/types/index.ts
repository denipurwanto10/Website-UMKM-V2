export type Usertype = 'Admin' | 'Owner';
export type UmkmStatus = 'menunggu' | 'disetujui' | 'ditolak';

export interface User {
  username: string;
  fullname: string;
  usertype: Usertype;
  nomor_hp: string;
  email: string;
  photo: string;
}

export interface Umkm {
  id: number;
  username: string;
  fullname?: string;
  nama_usaha: string;
  nama_merek_produk: string;
  kategori_produk: string;
  jenis_usaha: string;
  pendapatan: string;
  jalan: string;
  desa_kelurahan: string;
  kecamatan: string;
  nib: string | null;
  pirt: string | null;
  bpom: string | null;
  halal: string | null;
  haki: string | null;
  lainnya: string | null;
  online: string | null;
  offline: string | null;
  agen_reseller: string | null;
  deskripsi_produk: string;
  photo: string;
  status: UmkmStatus;
  catatan: string;
  whatsapp: string | null;
  blibli: string | null;
  lazada: string | null;
  shopee: string | null;
  tokopedia: string | null;
  facebook: string | null;
  instagram: string | null;
  tiktok: string | null;
  twitter: string | null;
}

export interface Promosi {
  id: number;
  username: string;
  fullname?: string;
  fasilitasi_promosi: string;
  hambatan_memasarkan_produk: string;
  bantuan_dibutuhkan: string;
  berminat_bazar_ramadhan: 'Ya' | 'Tidak';
  berminat_pelatihan_online: 'Ya' | 'Tidak';
}

export interface Stats {
  users: number;
  owners: number;
  admins: number;
  umkm: number;
  disetujui: number;
  perKategori: { kategori_produk: string; jumlah_umkm: number }[];
  perKecamatan: Record<string, unknown>[];
  jenisUsaha: { jenis_usaha: string; jumlah: number }[];
}

export interface AuthResponse {
  token: string;
  user: User;
}
