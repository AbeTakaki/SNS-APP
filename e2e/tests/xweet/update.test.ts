import { test, expect } from '@playwright/test'
import { testCreateXweet, testCreateUser, testLogin } from '../utils';
import { TEXT1 } from '../constants';

let user:any;
let user2:any;
let xweet:any;

test.beforeEach(async ({ request }) => {
  await request.post(`${process.env.TEST_API_URL}/api/test/reset-db`);
  user = await testCreateUser();
  user2 = await testCreateUser();
  xweet = await testCreateXweet(user.id,'Test Xweet');
});

test.afterEach(async ({ page }) => {
  await page.close();
});

test('非ログイン時、Xweet更新画面に移動するとログイン画面にリダイレクト', async ({ page }) => {
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet/create`);
  await page.waitForURL(`${process.env.TEST_FRONT_URL}/login`);
});

test('別ユーザでは、Xweet更新画面に移動できない', async ({ page }) => {
  await testLogin(page,user2.email,'password');
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet/update/${xweet.id}`);
  await page.waitForURL(`${process.env.TEST_FRONT_URL}/error/403`);
  await expect(page.locator('#forbidden')).toContainText(['403 Forbidden']);
});

test('ログイン後、Xweet更新画面に移動、Xweet更新しレスポンスが返る', async ({ page }) => {
  await testLogin(page,user.email,'password');
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet/update/${xweet.id}`);
  await expect(page.locator('textarea')).toContainText(['Test Xweet']);
  await page.locator('textarea').waitFor();
  await page.locator('#update-xweet').waitFor();
  await page.fill('textarea', 'Edited Test Xweet');
  await page.click('#update-xweet');
  await page.waitForURL(`${process.env.TEST_FRONT_URL}/xweet`);
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`);
  await expect(page.locator('#xweet-content')).toContainText(['Edited Test Xweet']);
});

test('ログイン後、バリデーションを満たさない内容では更新できない', async ({ page }) => {
  await testLogin(page,user.email,'password');
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet/update/${xweet.id}`);
  await page.locator('textarea').waitFor();
  await page.locator('#update-xweet').waitFor();
  await page.fill('textarea', TEXT1);
  await page.click('#update-xweet');
  await expect(page).not.toHaveURL(`${process.env.TEST_FRONT_URL}/xweet`);
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`);
  await expect(page.locator('#xweet-content')).not.toContainText([TEXT1]);
});