import Link from "next/link";
import React from "react";
import { user } from "@/src/types/types";

type Props = {
  users: user[];
}

export default function UserList({users}:Props){
  return(
    <>
      <div className="bg-white rounded-md shadow-lg mt-5 mb-5 ">
        <ul>
          {users?.map((user:user)=>(
            <li key={user.id} className="border-b last:border-0 border-gray-200 p-4">
              
            <div className="flex">
              <div className="ml-8">
                <p className="text-xl"><Link id="user-display" href={`/user/${user.user_name}`}>{user.display_name}</Link></p>
                <p>{user.profile}</p>
              </div>
            </div>
              
            </li>
          ))}
        </ul>
      </div>
    </>
  )
}