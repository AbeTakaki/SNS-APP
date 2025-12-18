import React from "react";
import Link from "next/link";
import { getFollows } from "@/src/lib/actions";
import { redirect } from "next/navigation";

type Props={
  params:Promise<{userName:string}>;
};

export default async function Page({params}:Props) {
  let data;
  try{
    const res = await getFollows((await params).userName);
    data = res;
  }catch(e){
    console.log((e as Error).message);
    redirect("/login");
  }

  return(
    <>
      <p>{data.displayName}さんがフォロー中</p>
      {data.users?.map((user:any)=>(
        <React.Fragment key={user.id}>
          <p><Link href={`/user/${user.user_name}`}>{user.display_name}</Link></p>
        </React.Fragment>
      ))}
    </>
  )
}