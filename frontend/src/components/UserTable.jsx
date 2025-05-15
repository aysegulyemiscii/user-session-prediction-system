import React from 'react';
import { format, parseISO } from 'date-fns';

const formatDate = (datetimeString) => {
  return format(parseISO(datetimeString), 'dd.MM.yyyy HH:mm');
};

const UserTable = ({ users }) => {
  return (
    <div className="overflow-x-auto">
      <table className="min-w-full border border-gray-400 shadow-md rounded-xl">
        <thead className="bg-gray-100 text-gray-700">
          <tr>
            <th className="py-3 px-4 text-left">Kullanıcı Adı</th>
            <th className="py-3 px-4 text-left">Son Login</th>
            <th className="py-3 px-4 text-left">Tahmin 1</th>
            <th className="py-3 px-4 text-left">Güven 1</th>
            <th className="py-3 px-4 text-left">Tahmin 2</th>
            <th className="py-3 px-4 text-left">Güven 2</th>
          </tr>
        </thead>
        <tbody>
          {users.map((user) => (
            <tr key={user.id} className="border-b hover:bg-gray-50">
              <td className="py-2 px-4">{user.name}</td>
              <td className="py-2 px-4">{formatDate(user.lastLogin)}</td>
              <td className="py-2 px-4">{user.prediction1}</td>
              <td className="py-2 px-4">{user.confidence1}%</td>
              <td className="py-2 px-4">{user.prediction2}</td>
              <td className="py-2 px-4">{user.confidence2}%</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default UserTable;