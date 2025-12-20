"use client"

import { useRouter } from "next/navigation";
import { useState } from "react";
import ButtonPost from "../element/buttonpost";
import { updateXweet } from "@/src/lib/actions";

type Props = {
  xweetId: number;
  content: string;
}

export default function UpdateForm({xweetId,content}:Props){
  const router = useRouter();
  const [error,setError] = useState<string|null>(null);

  const tryUpdateQuoot = async (data:FormData) =>{
    const res = await updateXweet(data,xweetId);
    if(res){
      setError(res);
    }else{
      router.push("/xweet"); 
    }
  }
  
  return(
    <>
      <form action={tryUpdateQuoot}>
        <textarea 
          id="xweet-content" 
          rows={3}
          name="xweet"
          className="focus:ring-blue-400 focus:border-blue-400 mt-1 block w-full text:text-sm border border-gray-300 bg-gray-100 text-gray-700 rounded-md p-2"
          defaultValue={content}></textarea>
        {error && <p className="text-red-500">{error}</p>}
        <div className="flex flex-wrap justify-end">
          <ButtonPost id="update-xweet" description="編集" />
        </div>
      </form>
    </>
  );
}