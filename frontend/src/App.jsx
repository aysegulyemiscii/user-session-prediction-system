import React, { useEffect, useState } from 'react';
import UserTable from './components/UserTable.jsx';

function App() {

  /* const dummyData = [
    {
      id: 'user_1',
      name: 'Ahmet',
      lastLogin: '2025-05-15 17:10',
      prediction1: '2025-05-15 17:15',
      prediction2: '2025-05-15 17:12'
    }
  ];*/

  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch('https://user-session-backend-us88.onrender.com/index.php')
      .then((res) => {
        if (!res.ok) throw new Error('Sunucu hatası');
        return res.json();
      })
      .then((data) => {
        console.log(data);
        setUsers(data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Yükleniyor...</div>;
  if (error) return <div>Hata: {error}</div>;

  return (
    <div className="min-h-screen bg-white p-6">
      <h1 className="text-3xl font-bold mb-6 text-center">Kullanıcı Oturum Tahminleri</h1>
      <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <p>
          <span class="font-medium">Tahmin 1 - </span>Algoritma : Ortalamama giriş aralığı, Ölçüt : Standart sapmanın 1 saaten az olması, Güven Skoru: %90 veya %65
        </p>
        <p>
          <span class="font-medium">Tahmin 2 - </span>Algoritma : En sık giriş saati, Ölçüt : En sık saatin tekrar sayısınin en az 3 olması, Güven Skoru: %85 veya %60
        </p>
      </div>
      <UserTable users={users} />
    </div>
  )
}

export default App
