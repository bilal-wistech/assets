<?php
namespace Aws\WellArchitected;

use Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Well-Architected Tool** service.
 * @method \Aws\Result associateLenses(array $args = [])
 * @method \GuzzleHttp\Promise\Promise associateLensesAsync(array $args = [])
 * @method \Aws\Result associateProfiles(array $args = [])
 * @method \GuzzleHttp\Promise\Promise associateProfilesAsync(array $args = [])
 * @method \Aws\Result createLensShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createLensShareAsync(array $args = [])
 * @method \Aws\Result createLensVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createLensVersionAsync(array $args = [])
 * @method \Aws\Result createMilestone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createMilestoneAsync(array $args = [])
 * @method \Aws\Result createProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createProfileAsync(array $args = [])
 * @method \Aws\Result createProfileShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createProfileShareAsync(array $args = [])
 * @method \Aws\Result createWorkload(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createWorkloadAsync(array $args = [])
 * @method \Aws\Result createWorkloadShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createWorkloadShareAsync(array $args = [])
 * @method \Aws\Result deleteLens(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteLensAsync(array $args = [])
 * @method \Aws\Result deleteLensShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteLensShareAsync(array $args = [])
 * @method \Aws\Result deleteProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteProfileAsync(array $args = [])
 * @method \Aws\Result deleteProfileShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteProfileShareAsync(array $args = [])
 * @method \Aws\Result deleteWorkload(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteWorkloadAsync(array $args = [])
 * @method \Aws\Result deleteWorkloadShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteWorkloadShareAsync(array $args = [])
 * @method \Aws\Result disassociateLenses(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disassociateLensesAsync(array $args = [])
 * @method \Aws\Result disassociateProfiles(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disassociateProfilesAsync(array $args = [])
 * @method \Aws\Result exportLens(array $args = [])
 * @method \GuzzleHttp\Promise\Promise exportLensAsync(array $args = [])
 * @method \Aws\Result getAnswer(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getAnswerAsync(array $args = [])
 * @method \Aws\Result getConsolidatedReport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getConsolidatedReportAsync(array $args = [])
 * @method \Aws\Result getLens(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLensAsync(array $args = [])
 * @method \Aws\Result getLensReview(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLensReviewAsync(array $args = [])
 * @method \Aws\Result getLensReviewReport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLensReviewReportAsync(array $args = [])
 * @method \Aws\Result getLensVersionDifference(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLensVersionDifferenceAsync(array $args = [])
 * @method \Aws\Result getMilestone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMilestoneAsync(array $args = [])
 * @method \Aws\Result getProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getProfileAsync(array $args = [])
 * @method \Aws\Result getProfileTemplate(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getProfileTemplateAsync(array $args = [])
 * @method \Aws\Result getWorkload(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getWorkloadAsync(array $args = [])
 * @method \Aws\Result importLens(array $args = [])
 * @method \GuzzleHttp\Promise\Promise importLensAsync(array $args = [])
 * @method \Aws\Result listAnswers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAnswersAsync(array $args = [])
 * @method \Aws\Result listCheckDetails(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCheckDetailsAsync(array $args = [])
 * @method \Aws\Result listCheckSummaries(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCheckSummariesAsync(array $args = [])
 * @method \Aws\Result listLensReviewImprovements(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLensReviewImprovementsAsync(array $args = [])
 * @method \Aws\Result listLensReviews(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLensReviewsAsync(array $args = [])
 * @method \Aws\Result listLensShares(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLensSharesAsync(array $args = [])
 * @method \Aws\Result listLenses(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLensesAsync(array $args = [])
 * @method \Aws\Result listMilestones(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMilestonesAsync(array $args = [])
 * @method \Aws\Result listNotifications(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listNotificationsAsync(array $args = [])
 * @method \Aws\Result listProfileNotifications(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listProfileNotificationsAsync(array $args = [])
 * @method \Aws\Result listProfileShares(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listProfileSharesAsync(array $args = [])
 * @method \Aws\Result listProfiles(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listProfilesAsync(array $args = [])
 * @method \Aws\Result listShareInvitations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listShareInvitationsAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result listWorkloadShares(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listWorkloadSharesAsync(array $args = [])
 * @method \Aws\Result listWorkloads(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listWorkloadsAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateAnswer(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateAnswerAsync(array $args = [])
 * @method \Aws\Result updateGlobalSettings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateGlobalSettingsAsync(array $args = [])
 * @method \Aws\Result updateLensReview(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateLensReviewAsync(array $args = [])
 * @method \Aws\Result updateProfile(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateProfileAsync(array $args = [])
 * @method \Aws\Result updateShareInvitation(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateShareInvitationAsync(array $args = [])
 * @method \Aws\Result updateWorkload(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateWorkloadAsync(array $args = [])
 * @method \Aws\Result updateWorkloadShare(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateWorkloadShareAsync(array $args = [])
 * @method \Aws\Result upgradeLensReview(array $args = [])
 * @method \GuzzleHttp\Promise\Promise upgradeLensReviewAsync(array $args = [])
 * @method \Aws\Result upgradeProfileVersion(array $args = [])
 * @method \GuzzleHttp\Promise\Promise upgradeProfileVersionAsync(array $args = [])
 */
class WellArchitectedClient extends AwsClient {}
