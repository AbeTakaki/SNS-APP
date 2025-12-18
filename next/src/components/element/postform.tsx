"use client"

import { createXweet } from "@/src/lib/actions";
import { useRouter } from "next/navigation";
import { useState } from "react";
import ButtonPost from "../element/buttonpost";

export default function PostForm(){
  const router = useRouter();
  const [error,setError] = useState<string|null>(null);

  const tryCreateQuoot = async (data:FormData) =>{
    const res = await createXweet(data);
    if(res){
      setError(res);
    }else{
      router.push("/xweet");   
    }
  }
  
  return(
    <>
      <form action={tryCreateQuoot}>
        <textarea 
          id="xweet-content" 
          rows={3}
          name="xweet"
          className="focus:ring-blue-400 focus:border-blue-400 mt-1 block w-full text:text-sm border border-gray-300 bg-gray-100 text-gray-700 rounded-md p-2"
          placeholder="つぶやきを入力"></textarea>
        {error && <p className="text-red-500">{error}</p>}
        <div className="flex flex-wrap justify-end">
          <ButtonPost id="create-xweet" description="投稿" />
        </div>
      </form>
    </>
  );
}