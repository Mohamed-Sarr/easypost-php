<?php

namespace EasyPost\Test;

use EasyPost\EasyPostClient;

class ScanFormTest extends \PHPUnit\Framework\TestCase
{
    private static $client;

    /**
     * Setup the testing environment for this file.
     */
    public static function setUpBeforeClass(): void
    {
        TestUtil::setupVcrTests();
        self::$client = new EasyPostClient(getenv('EASYPOST_TEST_API_KEY'));
    }

    /**
     * Cleanup the testing environment once finished.
     */
    public static function tearDownAfterClass(): void
    {
        TestUtil::teardownVcrTests();
    }

    /**
     * Test creating a scanForm.
     */
    public function testCreate()
    {
        TestUtil::setupCassette('scanForms/create.yml');

        $shipment = self::$client->shipment->create(Fixture::oneCallBuyShipment());

        $scanForm = self::$client->scanForm->create([
            'shipments' => [$shipment],
        ]);

        $this->assertInstanceOf('\EasyPost\ScanForm', $scanForm);
        $this->assertStringMatchesFormat('sf_%s', $scanForm->id);
    }

    /**
     * Test retrieving a scanForm.
     */
    public function testRetrieve()
    {
        TestUtil::setupCassette('scanForms/retrieve.yml');

        $shipment = self::$client->shipment->create(Fixture::oneCallBuyShipment());

        $scanForm = self::$client->scanForm->create([
            'shipments' => [$shipment],
        ]);

        $retrievedScanform = self::$client->scanForm->retrieve($scanForm->id);

        $this->assertInstanceOf('\EasyPost\ScanForm', $retrievedScanform);
        $this->assertEquals($scanForm, $retrievedScanform);
    }

    /**
     * Test retrieving all scanForms.
     */
    public function testAll()
    {
        TestUtil::setupCassette('scanForms/all.yml');

        $scanForms = self::$client->scanForm->all([
            'page_size' => Fixture::pageSize(),
        ]);

        $scanformsArray = $scanForms['scan_forms'];

        $this->assertLessThanOrEqual($scanformsArray, Fixture::pageSize());
        $this->assertNotNull($scanForms['has_more']);
        $this->assertContainsOnlyInstancesOf('\EasyPost\ScanForm', $scanformsArray);
    }
}
