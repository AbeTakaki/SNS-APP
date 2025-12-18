"use client"

import { canUpdateXweet, updateXweet } from "@/src/lib/actions";
import { useRouter } from "next/navigation";
import { useEffect, useState } from "react";
import { xweet } from "@/src/types/types";


type Props = {
  params:Promise<{xweetId:number}>;
};

export default function Page({params}:Props) {
  const router = useRouter();
  const [error, setError] = useState<string|null>(null);
  const [data, setData] = useState<xweet>();

  useEffect(() => {
    const tryCanUpdateXweet = async() => {
      try {
        const res = await canUpdateXweet((await params).xweetId);
        setData(res);
      }catch(e) {
        console.log((e as Error).message);
        router.push("/error/403");
      }
    }
    tryCanUpdateXweet();
  },[])

  const tryUpdateXweet = async (data:FormData) => {
    const res = await updateXweet(data,(await params).xweetId);
    if(res){
      setError(res);
    }else{
      router.push("/xweet");
    }
  }

  return(
    <>
      {data &&
        <div>
          <h1>Xweet更新画面</h1>
          <div>
            <p>更新フォーム</p>
            <form action={tryUpdateXweet}>
              <textarea 
                id="xweet-content" 
                name="xweet" 
                className="block mt-1 bg-gray-100 text-gray-700"
                defaultValue={data.content}
              />
              <button type="submit">更新</button>
              {error && <p className="text-red-500">{error}</p>}
            </form>
          </div>
        </div>
      }
    </>
  )
}