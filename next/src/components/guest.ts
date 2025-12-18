import { redirect } from "next/navigation";
import { ReactNode } from "react";
import { getUserData } from "../lib/actions";

type Props = {
  children: ReactNode;
};

export default async function Guest({children}:Props){
  let isLogin:boolean = false;
  const tryGetUserData = async() =>{
    try{
      await getUserData();
      isLogin = true;
    }catch(e){
      console.log((e as Error).message);
    }
  }
  await tryGetUserData();
  if(isLogin) redirect("/xweet");
  return children;
}